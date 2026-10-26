pipeline {
    agent any

    options {
        disableConcurrentBuilds()
    }

    triggers {
        pollSCM('H/2 * * * *')
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Prepare Environment') {
            steps {
                sh '''
                    if [ ! -f .env ]; then
                        cp docker/env.docker .env
                        sed -i "s|^APP_KEY=.*|APP_KEY=base64:$(openssl rand -base64 32)|" .env
                    fi
                    echo ".env is ready"
                '''
            }
        }

        stage('Build Docker Images') {
            steps {
                sh 'docker compose build'
            }
        }

        stage('Test') {
            steps {
                sh '''
                    docker run --rm --entrypoint "" --env-file .env \
                      -e DB_CONNECTION=sqlite -e DB_DATABASE=:memory: -e APP_ENV=testing \
                      laravel-app:latest php artisan test
                '''
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker compose up -d --remove-orphans'
            }
        }

        stage('Verify') {
            steps {
                sh '''
                    code=000
                    for i in $(seq 1 30); do
                        code=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 || true)
                        echo "Attempt $i -> HTTP $code"
                        [ "$code" = "200" ] && break
                        sleep 3
                    done
                    [ "$code" = "200" ]
                    docker compose ps
                    docker compose exec -T db mysql -ularavel -ppassword laravel -e "SHOW TABLES;"
                '''
            }
        }
    }

    post {
        success {
            echo 'Deployed. Open http://localhost:8000'
        }
        failure {
            sh 'docker compose logs --tail=100 || true'
        }
    }
}
