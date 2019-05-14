mails = 'diomyero.sow@orange-sonatel.com papemor.coundoul@orange-sonatel.com'

pipeline {
  agent  {
    label 'php7'
  }
  options {
        timeout(time: 120, unit: 'MINUTES')
  }
  tools {
    maven "Maven_3.3.9"
  }

  stages {

    stage('Check Scm Changelog') {
        steps {
          script {
            def changeLogSets = currentBuild.changeSets
            for (int i = 0; i < changeLogSets.size(); i++) {
                def entries = changeLogSets[i].items
                for (int j = 0; j < entries.length; j++) {
                    def entry = entries[j]
                    if(entry.author.toString().contains('Jenkins') || entry.msg.contains('maven-release-plugin')){
                      echo "Les Commit effectués par le user jenkins sont toujours ignorés. C'est le cas des releases effectuées depuis la chaine d'integration avec le user jenkins"
                        currentBuild.result = 'ABORTED'
                        error('Aucun besoin de builder de façon cyclique les commits de Jenkins')
                        return
                    }else{
                      echo "ID Commit : ${entry.commitId} \nAuteur : ${entry.author} \nDate : ${new Date(entry.timestamp)} \nMessage: ${entry.msg}"
                      def files = new ArrayList(entry.affectedFiles)
                      for (int k = 0; k < files.size(); k++) {
                          def file = files[k]
                          echo "  ${file.editType.name} ${file.path}"
                      }
                    }
                }
            }
          }
        }
    }


    stage('Composer install') {
      steps {
        sh 'composer install'
      }
    }


    stage('Unit Tests') {
      steps {
        sh 'vendor/phpunit/phpunit/phpunit  -c phpunit.xml  --log-junit \'reports/unitreport.xml\' --coverage-clover \'reports/cloverreport.xml\'   --testsuite unit'

      }
    }

    stage('Integration Tests') {
      steps {
        sh 'echo \'tests d\'intégration'
      }
    }

    stage('SonarQube Scan') {
      steps{
        script{
            withSonarQubeEnv('SonarQubeServer') {
            sh 'mvn sonar:sonar -X'
           }
       }
     }
    }

    stage("Waiting for Sonar analysis to complete"){
      steps{
        script{
          sleep time: 1, unit: 'MINUTES'
        }
      }
    }



    stage("SonarQube Quality Gate") {
      steps{
        script{
          timeout(time: 12, unit: 'MINUTES') {
              def qg = waitForQualityGate()
              if (qg.status != 'OK') {
                error "Pipeline aborted due to quality gate failure: ${qg.status}"
              }
          }
        }
      }
    }



   /* Modifier le profil selon vos profils projet */

    stage('Deploy REC') {
      steps {
        sh 'mvn clean install -P REC -Dskip.deploy=false'
      }
    }


    stage('Functionnals Tests Phases') {
      steps {
        parallel(
          "NR Tests": {
            echo 'Pas de tests pour le moment'

          },
          "Functionnals Tests": {
            echo 'Pas de tests pour le moment'

          }
        )
      }
    }


/*

    stage('Launch Qualys Scan') {
      agent { label 'qualys' }
      steps {
        sh 'mvn qualys:scan -X'
      }
  }


  stage('Check Qualys Scan') {
      steps {
          script{
            timeout(time:90, unit: 'MINUTES'){
              waitUntil {
                sleep time: 7, unit: 'MINUTES'
                try{
                  sh 'mvn qualys:check -X'
                  def result = manager.logContains(".*SCAN-FINISHED*.")

                  if(result)
                    return true
                }catch(exc){
                  echo 'Une exception a été rencontrée... Retry en cours'
                }
                return false
              }
            }
          }
      }
  }

 stage('Qualys Download Report') {
       steps {
           sh 'mvn qualys:report'
           sleep time: 1, unit: 'MINUTES'
           sh 'mvn qualys:download'
       }
       post{
        success {
          archiveArtifacts artifacts: 'target/qualys/*.pdf'
          emailext attachmentsPattern: 'target/qualys/*.pdf',
            body: 'Rapport Qualys joint au mail.',
            subject: '[QUALYS] Rapport Vulnerabilité',
            to: 'papemor.coundoul@orange-sonatel.com'
        }
       }
    }

  stage('Analyse Qualys Report') {
      steps {
       script{
         try{
            sh 'mvn qualys:analyse-prepare'
          }catch(exc){
            echo 'Une exception a été rencontrée pendant qualys:analyse-prepare'
          }
         sleep time: 1, unit: 'MINUTES'
         sh 'mvn qualys:analyse-perform'

          }
       }
   }
*/

stage('Release On Nexus') {
     when {
      branch 'release'
     }
      steps {
        build job: 'Portail-Release'
      }
    }

  }
  post {

   changed {
      emailext attachLog: true, body: '$DEFAULT_CONTENT', subject: '$DEFAULT_SUBJECT',  to: 'papemor.coundoul@orange-sonatel.com'
   }
   /* always{
        sh 'mvn clean'
         cleanWs deleteDirs: true, notFailBuild: true
    } */
    failure {
      emailext attachLog: true, body: '$DEFAULT_CONTENT', subject: '$DEFAULT_SUBJECT',  to: 'papemor.coundoul@orange-sonatel.com'
    }
  }
}
