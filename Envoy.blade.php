@servers(['web' => 'ijin82@wired-mind.info'])

@task('deploy-prod', ['on' => 'web'])
    cd /home/ijin82/wired-mind
    git pull origin master
    php artisan cache:clear
    php artisan clear-compiled
    php artisan config:cache
    php artisan route:cache
@endtask
