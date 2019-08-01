window.addEventListener('load', function() {

  //3 formas de llamar dialogo A2HS Dialog Mini-infobar crome A2HS banner

var insallApp = document.getElementById('insallApp');
var btnYes    = document.getElementById('btnYes');
var btnNo    = document.getElementById('btnNo');


// Detects if device is on iOS
const isIos = () => {
  const userAgent = window.navigator.userAgent.toLowerCase();
  var isAndroid = /android/i.test(navigator.userAgent.toLowerCase());
  var isiDevice = /ipad|iphone|ipod/i.test(navigator.userAgent.toLowerCase());

  var result =localStorage.getItem("choiceResult");
 
  

 
  if(isAndroid || isiDevice){
    localStorage.setItem("choiceResult", "no");
  }else{
  
    if(result === null){
      insallApp.classList.add("showApp");
    }
  }


  
  return /iphone|ipad|ipod/.test( userAgent );
}



// Checks if should display install popup notification:
if (isIos() && !isInStandaloneMode()) {
  this.setState({ showInstallMessage: true });
}






var deferredPrompt;

   window.addEventListener('beforeinstallprompt', function(e) {
      // Prevent Chrome 67 and earlier from automatically showing the prompt
      e.preventDefault();
      // Stash the event so it can be triggered later.
      deferredPrompt = e;
        // alert(localStorage.getItem("choiceResult")+'xxx');
      // retrieve data value
    
      
    });



btnYes.addEventListener('click', (e) => {
  // hide our user interface that shows our A2HS button
  insallApp.classList.remove("showApp");
  // Show the prompt
  deferredPrompt.prompt();
  // Wait for the user to respond to the prompt
  deferredPrompt.userChoice
    .then((choiceResult) => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the A2HS prompt');
        // save data value
        localStorage.setItem("choiceResult", "yes");
      } else {
        console.log('User dismissed the A2HS prompt');
        // save data value
        // insallApp.classList.remove("showApp");
        // localStorage.setItem("choiceResult", "no");
        
      }
     
      deferredPrompt = null;
    });

});


btnNo.addEventListener('click', (e) => {
  console.log('User denie');
       // save data value
    insallApp.classList.remove("showApp");
    // localStorage.setItem("choiceResult", "no");
  });
  
  

window.addEventListener('appinstalled', (evt) => {
  console.log('a2hs installed');
 insallApp.classList.remove("showApp");
 
});








});


