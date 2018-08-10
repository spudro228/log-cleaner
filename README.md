# log-cleaner

При незначительных изменениях делать так

```
 cd packages/ec-crm/LogCleaner
 git add .
 git commit -m "Удалил депрекейтед интерфейс"
 git push -u origin master
 git tag -a 1.0.x -m "release: some fix" ( вместо "х" - цыфру следующей версии)
 git push --tags
```