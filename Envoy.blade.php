@servers(['web' => 'ijin82@wired-mind.info'])

@task('deploy-prod', ['on' => 'web'])
    cd /home/ijin82/wired-mind
    git pull origin master
@endtask
