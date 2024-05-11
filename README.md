# test_app

### Api

- GET|HEAD `api/mining/start`
- GET|HEAD `api/mining/taps/increment/{count}`
- GET|HEAD `api/mining/user`
- GET|HEAD `api/referral/link`
- GET|HEAD `api/user`
- GET|HEAD `api/users`

### Api response error codes

`401` - invalid Telegram WebApp initData\
`419` - when first init app, when player not found, for redirect him to create acount(start mining)\
`422` - invalid Telegram WebApp initData

### Prod seeders
```shell
php artisan db:seed --class=CategoryOfStackSeeder
php artisan db:seed --class=LevelSeeder
```


### Business logic

*Mining process*
- Player can tap ($palyer->taps)
- `taps` convert to `score` ($palyer->score) 
- `score` are calculated using multipliers multiplied by `tabs` ('score = multipliers * taps')
- `balance` ($palyer->balance) are calculated by adding `score` and some `claims`

*Referrals system*
- Player can invite frends by `referral_link` ($palyer->referral_link)
- `referral_link` saved just one time by clicking `/start` after activate `referral_link`

<hr>

### TODO Simple List

- [x] `/checkin` endpoint
- [x] `server_now` field
- [x] add auto checkin when fire increment endpoint
- [x] `rates` field
- [x] `stacks` model with category
- [x] main_stack field to player
- [x] ava+ first last name
- [x] level by balance
- [ ] sort rates by level
- [ ] skils with category
- [ ] Comet Haley
