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
                sh 'composer install --no-interaction --prefer-dist'
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
            }
        }
    }
}
