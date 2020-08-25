@servers(['web' => 'root@wired-mind.info -p 9988'])

@task('deploy-PROD')
    su -l ijin
    cd /home/ijin/projects/php/wired-mind
    git pull origin master

    {{-- envoy run deploy --composer --}}
    @if ($composer)
        /home/ijin/.bin/composer install
    @endif

    {{-- envoy run deploy --migrate --}}
    @if ($migrate)
        /usr/bin/php artisan migrate --force
    @endif

    /usr/bin/php artisan clear-compiled
    /usr/bin/php artisan cache:clear
    /usr/bin/php artisan route:cache
    /usr/bin/php artisan config:cache
@endtask
