pipeline {
    agent any

    environment {
        DOCKER_HUB_USER = 'umarhashmi123'
        IMAGE_NAME      = "${DOCKER_HUB_USER}/laravel-app"
        REGISTRY_CRED   = 'dockerhub-credentials-id'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build & Push Docker Image') {
            steps {
                script {
                    sh "docker build -t ${IMAGE_NAME}:${BUILD_NUMBER} -t ${IMAGE_NAME}:latest ."
                    withCredentials([usernamePassword(credentialsId: "${REGISTRY_CRED}", usernameVariable: 'USER', passwordVariable: 'PASS')]) {
                        sh "echo ${PASS} | docker login -u ${USER} --password-stdin"
                        sh "docker push ${IMAGE_NAME}:${BUILD_NUMBER}"
                        sh "docker push ${IMAGE_NAME}:latest"
                    }
                }
            }
        }

        stage('Deploy Database Tier') {
            steps {
                sh "kubectl apply -f k8s/mysql-deployment.yaml"
            }
        }

        stage('Deploy Application Tier') {
            steps {
                sh "kubectl apply -f k8s/nginx-configmap.yaml"
                sh """
                    sed -i 's|umarhashmi123/laravel-app:BUILD_NUMBER|${IMAGE_NAME}:${BUILD_NUMBER}|g' k8s/laravel-deployment.yaml
                    kubectl apply -f k8s/laravel-deployment.yaml
                    kubectl rollout status deployment/laravel-app --timeout=120s
                """
            }
        }
    }

    post {
        always {
            sh "docker logout"
        }
    }
}
