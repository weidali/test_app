# test_app

### Api

GET|HEAD `api/mining/start`
GET|HEAD `api/mining/taps/increment/{count}`
GET|HEAD `api/mining/user`
GET|HEAD `api/referral/link`
GET|HEAD `api/user`

### Api response error codes

`401` - invalid Telegram WebApp initData
`419` - when first init app, when player not found, for redirect him to create acount(start mining)
`422` - invalid Telegram WebApp initData

