

window.addEventListener('load', function(e){

            var sending = document.querySelector("#sending");

            var spanReponse = document.querySelector("#reponse");

            var form = document.querySelector('form');

            sending.addEventListener('click', function(event){
                // arreter la fonction click avant le submit pour catch les consolelog
                // event.preventDefault();
            
                    executeXHR(e);
    
            });

            function executeXHR(e) {
            var xhr = new XMLHttpRequest(); // on instanci un noueau XML
            //  gestionnaire d’événements qui prend en charge les changements d’état de la requête
            xhr.onreadystatechange = function () {
                console.log(xhr.readyState); //readyState: retourne l’état de la requête
                switch (xhr.readyState) {
                    case 1:
                        break;
                    case 2:
                        break;
                    case 3:
                        break;
                    case 4:
                        if( xhr.status==200 ) {
                            //le contenu du span sera concaténé de la responseText: réponse du serveur sous forme de chaîne de caractères
                              
                            var jsonReponse = JSON.parse(xhr.responseText); // on met la valeur du fichier php en JSON ;
                         
                             switch(jsonReponse.code)
                             {
               
                                case 'wrong':
                                spanReponse.style.backgroundColor='lightgreen';
                                spanReponse.style.color='red';
                                 spanReponse.style.fontSize = '20px';
                                break;

                                case 'empty':
                                spanReponse.style.backgroundColor='lightblue';
                                spanReponse.style.color='red';
                                spanReponse.style.fontSize = '20px';
                                break;

                                case 'already':
                                spanReponse.style.backgroundColor='lightred';
                                spanReponse.style.color='blue';
                                 spanReponse.style.fontSize = '20px';
                                break;
                                 case 'good':
                                spanReponse.style.backgroundColor='lightbrown';
                                spanReponse.style.color='blue';
                                 spanReponse.style.fontSize = '20px';
                                break;
                               


                            
                            }
                             // spanReponse.innerHTML = xhr.responseText;  // en XML
                             spanReponse.innerHTML = jsonReponse.msg; // On affiche la réponse textuelle en JSON

                            console.log(jsonReponse.msg);
                            console.log(jsonReponse.code);
                            
                        } else {
                            alert( 'Une erreur est survenue ' );
                            console.log( xhr.status + ' : ' + xhr.statusText );
                        }
                       
                }
            }

    
            if(sending.getAttribute( 'data-method' ) =='POST')  // si l'element sur le quel on clique est un post ..
               
            {   // on initialise la requête selon une série de paramètres fournis en arguments
                 xhr.open( 'POST','envoi.php', true );
                 
                xhr.setRequestHeader( 'Content-Type', 'application/json' );
                var formDatas = new FormData( form );
                console.log(formDatas);
                 for (var value of formDatas.entries()) 
                    {  
                        console.log(value[1]); 
                    }
     
                //et on effctue la requête, avec éventuellement l’envoi de données
                xhr.send( formDatas );
            }
      e.preventDefault();      
    }        
});





