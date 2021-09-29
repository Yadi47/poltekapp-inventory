def addition(n):
    return {'column':n[0]}
  
# We double all numbers using map()
numbers =  [
    [
      'TANK-01.Status',
      'false',
      'Good',
      '2021-03-24 10:07:17.265000+00:00'
    ],
    [
      'TANK-01.Temperature',
      61,
      'Good',
      '2021-03-25 14:08:42.186000+00:00'
    ],
    [
      'TANK-01.Product Name',
      'ETHANOL',
      'Good',
      '2021-03-24 10:07:17.265000+00:00'
    ]
  ]
result = map(addition, numbers)
print(list(result))