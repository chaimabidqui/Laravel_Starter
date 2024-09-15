pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                git 'https://github.com/DAR-DIGITAL/Laravel_Starter.git'
                sh 'composer install'
                sh 'composer dump-autoload'
                sh 'php artisan key:generate'
                sh 'php artisan migrate'
                sh 'php artisan migrate:fresh --seed'
                sh 'php artisan storage:link'
            }
        }

        stage('Test') {
            steps {
                sh 'php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                sh 'php artisan deploy'
            }
        }
    }
}