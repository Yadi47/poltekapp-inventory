var datetime = require('node-datetime');
const csv = require('csv-parser');
var csvEncoding = { encoding: 'utf16le' };
const fs = require('fs');
var glob = require("glob");
var path = require('path');
const {
    Client
} = require('pg')
var InfiniteLoop = require('infinite-loop');
var il = new InfiniteLoop();

// DEFINISIKAN PATH GENERATE DAN IMPORT
var path = '../adjustment/';



const conn = require('./pgsqlconnection');

const query = require('./pgsqlquery');



// CEK FILE YANG SUDAH DI IMPORT
async function checkFileImport() {
    return await new Promise((resolve, reject) => {
        conn.client.query('SELECT * from csv_imports', (err, res) => {
            resolve(res.rows);
            reject(err);
        })
    })
}

// CEK FILE DI ROOT
async function checkFileRoot() {
    return await new Promise((resolve, reject) => {
        glob.glob("**/*.csv", {
            cwd: path
        },
            function (err, res) {
                resolve(res)
                reject(err);
            });
    })
}

// INSERT PROCESS
async function insertProcess(dateTime, csvGenerated) {

    return new Promise((resolve, reject) => {
        // LOOP SEMUA DATA YANG BELUM DIIMPORT
        for (let index = 0; index < csvGenerated.length; index++) {
            // DEFINISI INSERT CSV_IMPORTS
            let data = {};
            data['file_name'] = csvGenerated[index];
            data['process_type'] = csvGenerated[index].split("_")[0];
            data['datetime'] = dateTime;
            // JIKA TIPE DATFILE TRF
            // if (data['process_type'] === 'TRF') {
            // BACA ISI CSV TRF
            let file = path + data['file_name'];
            let results = [];

            fs.createReadStream(file, csvEncoding)
                .pipe(csv({
                    separator: ';',
                    headers: false
                }))
                .on('data', (data) => results.push(data))
                .on('end', () => {

                    // LOOP ISI FILE
                    // console.log(results)
                    for (const t in results) {
                        if (results.hasOwnProperty(t)) {

                            // DEFINISI INSERT TRF
                            const element = results[t];
                            let row_csv = {};
                            //console.log(element)
                            if (typeof element['1'] !== "undefined") {

                                row_csv['jurnal'] = element['0']
                                row_csv['type'] = element['1']
                                row_csv['date'] = element['2']
                                row_csv['item_number'] = element['3']
                                row_csv['warehouse'] = element['4']
                                row_csv['location'] = element['5']
                                row_csv['quantity'] = element['6']
                                row_csv['silo'] = silo(element['5']);
                                row_csv['file_name'] = data['file_name']
                                // console.log(row_csv);

                                // --- INSERT ROW
                                query.insert('silo_adjustments', row_csv, function (res) {
                                    // console.log(res.msg)
                                });

                                // --- INSERT ROW
                                query.insert('temp_silo_adjustments', row_csv, function (res) {
                                    // console.log(res.msg)
                                });

                                // //  INSERT CSV_IMPORTS
                                query.insert('csv_imports', data, function (res) {
                                    // console.log(res.msg)
                                });
                            }

                        }
                    }
                });
            // }

        }
    })
}

// -- Silo Splice
function silo(silo) {
    return parseInt(silo.match(/(\d+)/)[0]) + 500;
}
// LOOP PROCESS
async function loop() {
    var FileImports = await checkFileImport();
    var csvGenerated = await checkFileRoot();
    var dt = datetime.create();
    var dateTime = dt.format('Y-m-d H:M:S');
    // CEK UNTUK FILTER DATA YANG SUDAH DI IMPORT 
    for (const key in FileImports) {
        if (FileImports.hasOwnProperty(key)) {
            let FileImport = FileImports[key]['file_name'];
            csvGenerated = csvGenerated.filter(function (item) {
                // RETURN DATA YANG BELUM DIIMPORT
                return item !== FileImport
            })

            // console.log(csvGenerated)
        }
    }
    // PROCESS INSERT
    // console.log('===================');
    await insertProcess(dateTime, csvGenerated);
}

il.setInterval(300000).add(loop).run();