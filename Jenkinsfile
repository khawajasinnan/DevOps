pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                echo 'Installing Laravel dependencies'
                sh 'php -v'
                sh 'composer install --no-interaction --prefer-dist --no-progress'
                sh 'cp -n .env.example .env || true'
                sh 'php artisan key:generate --force'
            }
        }

        stage('Test') {
            steps {
                echo 'Running Laravel tests'
                sh 'php artisan test'
            }
        }

        stage('Deploy') {
            steps {
                echo 'Preparing Laravel application for deployment'
                sh 'php artisan --version'
                sh 'php artisan route:list'
            }
        }
    }
}
