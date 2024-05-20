# test_app

### Api

- GET|HEAD `api/mining/start`
- GET|HEAD `api/mining/taps/increment/{count}`
- GET|HEAD `api/mining/user`
- GET|HEAD `api/referral/link`
- GET|HEAD `api/user`
- GET|HEAD `api/users`
- GET|HEAD `api/levels`
- GET|HEAD `api/levels/check`
- GET|HEAD `api/player/theme/{theme}`
- GET|HEAD `api/mining/taps/earn-per-tap/{count}`
- GET|HEAD `api/mining/taps/max-taps/{count}`
- GET|HEAD `/api/stacks/categories`
- GET|HEAD `/api/stacks`
- GET|HEAD `/api/stacks/add-main/{stack_id}`
- GET|HEAD `/api/stacks/main`

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

- [x] `/sync` endpoint
- [x] `server_now` field
- [x] add auto `last_sync_update` when fire increment endpoint
- [x] `rates` field
- [x] `stacks` model with category
- [x] main_stack field to player
- [x] ava+ first last name
- [x] level by balance
- [x] last_sync_update field instead checkin 	20.05.2024
- [x] api sync instead checkin					20.05.2024
- [ ] api list all main stacks by language 		20.05.2024
- [ ] earn_passive_per_hour				 		20.05.2024
- [ ] store level for player
- [ ] sort rates by level
- [ ] skils with category
- [ ] Comet Haley
