# SE-SDK

# install

add this code to your composer.json
  
``` bash
"repositories":[
      {
          "type": "vcs",
          "url" : "git@bitbucket.org:smartexpert/se-sdk.git"
      }
  ]
```

add to require:

``` bash
"se/sdk": "dev-master"
```
run

``` bash
composer update
```

### config s3

```dotenv
FILESYSTEM_CLOUD=minio

MINIO_ENDPOINT="http://157.230.121.142:9000"
AWS_KEY=
AWS_SECRET=
AWS_REGION=eu-central-1
AWS_BUCKET=platform
```
