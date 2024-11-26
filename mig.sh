#!/bin/bash
php artisan scribe:generate;
git add --all;
git commit -m "Scribe.Regenerate";
git checkout develop;
git merge Charles;
git push;
git checkout Charles;