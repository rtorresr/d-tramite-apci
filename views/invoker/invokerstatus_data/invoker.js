var $jq = jQueryWEB.noConflict();
var webSocket;
var type;
var idWsComponent;
var split = '-@@-';
var app = 'jnlps://dsp.reniec.gob.pe/refirma_invoker/servlet';
var wss = 'wss://dsp.reniec.gob.pe/refirma_invoker_wss/websocket';
//var app = 'jnlp://localhost:8080/refirma_invoker/servlet';
//var wss = 'ws://localhost:8080/refirma_invoker_wss/websocket';

$jq(window).load(function() {
	load();		
	$jq('#mdlInvoker').modal({backdrop:'static', keyboard:false})
});

window.addEventListener('message', function messageFromParent(e){	
	message = e.data;		
	if(message.init != null){
		$jq('#mdlInvoker').modal({backdrop:'static', keyboard:false});	
		openSocket(message.init);			
	}
	if(message.arguments != null){		
		webSocket.send(window.btoa(idWsComponent + split + message.arguments));
		return false;
	}	
});

function postMessageToParent(message) {	
	window.parent.postMessage(message, '*');
}
				
function openSocket(opt){					
	type = opt;					
			
	if(webSocket !== undefined && webSocket.readyState !== WebSocket.CLOSED){
       alert("WebSocket ya está abierto.");		              
       return;
    }
   
    webSocket = new WebSocket(wss);  		                       
   
    webSocket.onopen = function(event){                
        if(event.data === undefined)		                	
        	return;			            		                    
        if (event.data == "expired") {	                	 
        	alert("La sesión expiró.");	
        	$jq('#mdlInvoker').modal('hide');		                	
        }		                
    };

    webSocket.onmessage = function(event){
			debugger;
			console.log(event.data);
    	result = event.data;
    	//console.log(result);
    	if(result.indexOf('IdInvokerWS') >= 0){
       		$jq('#status').text('Enviando argumentos...');   
       		idWsComponent = result.replace('IdInvokerWS', '');
       		document.getElementById('frameInvokerJWS').setAttribute('src', '#');       		
       		postMessageToParent('getArguments');           		
					return;
    	}else if(result.indexOf('entity_data_name') >= 0){
				$jq('#entity_data_name').html('<div class="animated fadeIn">' + '<i class="glyphicon glyphicon-pushpin"></i>&#160;&#160;' + result.replace('entity_data_name', '') + '</div>');		    
				// $jq('#entity_data_name').html('<div class="animated fadeIn">' + '<i class="glyphicon glyphicon-pushpin"></i>&#160;&#160;' + "RENIEC" + '</div>');		    
    		return;
    	}else if(result.indexOf('entity_data_app') >= 0){
				$jq('#entity_data_app').html('<div class="animated fadeIn">' + result.replace('entity_data_app', '') + '</div>');		    
				// $jq('#entity_data_app').html('<div class="animated fadeIn">' + "Sistema de trámite documentario - Firma Digital" + '</div>');		    
    		return;
		}else if(result !== 'init' && result !== 'getDocument' && result !== 'sign' && result !== 'upload' && result !== 'ok' && result !== 'cancel' && result !== 'processOk' && result !== 'processCancel'){			            	
					document.getElementById('frameInvokerJWS').setAttribute('src', app + '?id=' + result);			
					console.log('src' + app + '?id=' + result);
        	return;       				    	
		}
		if(result === 'init'){			  			
			$jq('#status').text('Obteniendo documento a firmar...');	
			return; 
		} 
		if(result === 'getDocument'){		
			setTimeout(function () {
				$jq("#imgLoad").css("display", "none");
				$jq("#imgDownload").css("display", "inherit");	
				$jq("#imgSign").css("display", "none");	
				$jq("#imgUpload").css("display", "none");
				$jq("#imgOk").css("display", "none");	
				$jq("#imgCancel").css("display", "none");
				$jq('#status').text('Obteniendo documento a firmar...');        		            	
            }, 100);	
			return; 
		} 
		if(result === 'sign'){		
			$jq("#imgLoad").css("display", "none");
			$jq("#imgDownload").css("display", "none");	
			$jq("#imgSign").css("display", "inherit");	
			$jq("#imgUpload").css("display", "none");		
			$jq("#imgOk").css("display", "none");	
			$jq("#imgCancel").css("display", "none");				
			$jq('#status').text('Firmando digitalmente el documento...');	 
			return; 
		}						
		if(result === 'upload'){
			$jq("#imgLoad").css("display", "none");
			$jq("#imgDownload").css("display", "none");	
			$jq("#imgSign").css("display", "none");	
			$jq("#imgUpload").css("display", "inherit");
			$jq("#imgOk").css("display", "none");	
			$jq("#imgCancel").css("display", "none");
			$jq('#status').text('Subiendo documento firmado...');	
			return; 
		}  
		if(result === 'ok'){
			$jq("#imgLoad").css("display", "none");
			$jq("#imgDownload").css("display", "none");	
			$jq("#imgSign").css("display", "none");	
			$jq("#imgUpload").css("display", "none");	
			$jq("#imgOk").css("display", "inherit");	
			$jq("#imgCancel").css("display", "none");
			$jq('#status').text('Proceso de firma digital terminado.');
			return; 
		} 
		if(result === 'cancel'){
			$jq("#imgLoad").css("display", "none");
			$jq("#imgDownload").css("display", "none");	
			$jq("#imgSign").css("display", "none");	
			$jq("#imgUpload").css("display", "none");	
			$jq("#imgOk").css("display", "none");	
			$jq("#imgCancel").css("display", "inherit");			
			$jq('#status').text('Proceso de firma digital cancelado.');	
			return; 
		}						          	
    };

    webSocket.onclose = function(event){  		 				
		setTimeout(function () {
			$jq('#mdlInvoker').modal('hide');
			setTimeout(function () {
				postMessageToParent('close');
				if(result === 'processOk'){			
					postMessageToParent('invokerOk');			        		            	
				}
				if(result === 'processCancel'){ 		            		
					postMessageToParent('invokerCancel');					        		            	
				} 	
			}, 300);				
		}, 1000);   			
    };			

    webSocket.onerror = function(event) {
		//alert(event.data);
	};                       
}	

function load(){
	$jq("#imgLoad").css("display", "inherit");					
	$jq("#imgDownload").css("display", "none");	
	$jq("#imgSign").css("display", "none");	
	$jq("#imgUpload").css("display", "none");		
	$jq("#imgOk").css("display", "none");	
	$jq("#imgCancel").css("display", "none");
	$jq('#status').text('Cargando el componente...');
}


