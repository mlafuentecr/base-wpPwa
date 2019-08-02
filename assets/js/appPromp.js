window.addEventListener('load', function() {

  //3 formas de llamar dialogo A2HS Dialog Mini-infobar crome A2HS banner
  const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);
var insallApp = document.getElementById('insallApp');
var btnYes    = document.getElementById('btnYes');
var btnNo    = document.getElementById('btnNo');

if( screen.width <= 480 ) {
  // is mobile..
  this.console.log(' ---------Dont show pc banner in android');
  localStorage.setItem("choiceResult", "no");
}else if( screen.width > 480 ){

if(localStorage.getItem("choiceResult") === null){
  document.getElementById('insallApp').classList.add("showApp");
  this.console.log(' ---------show app in laptop');
  //si es latop muestre banner
}

}


// Detects if device is on iOS
const isIos = () => {
  const userAgent = window.navigator.userAgent.toLowerCase();

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
        localStorage.setItem("choiceResult", "yes dont show more banner");
      } else {
        console.log('User dismissed the A2HS prompt');
        // save data value
        // insallApp.classList.remove("showApp");
        localStorage.setItem("choiceResult", "no dont show more banner");

      }

      deferredPrompt = null;
    });

});


btnNo.addEventListener('click', (e) => {
  console.log('User denie');
       // save data value
    insallApp.classList.remove("showApp");
   localStorage.setItem("choiceResult", "no dont show more banner");
  });



window.addEventListener('appinstalled', (evt) => {
  console.log('a2hs installed');
 insallApp.classList.remove("showApp");
 localStorage.setItem("choiceResult", "installed dont show more banner");
});







});


