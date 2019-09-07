<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<style>
    .mytext{
    border:0;padding:10px;background:whitesmoke;
}
.text{
    width:75%;display:flex;flex-direction:column;
}
.text > p:first-of-type{
    width:100%;margin-top:0;margin-bottom:auto;line-height: 13px;font-size: 12px;
}
.text > p:last-of-type{
    width:100%;text-align:right;color:silver;margin-bottom:-7px;margin-top:auto;
}
.text-l{
    float:left;padding-right:10px;
}        
.text-r{
    float:right;padding-left:10px;
}
.avatar{
    display:flex;
    justify-content:center;
    align-items:center;
    width:25%;
    float:left;
    padding-right:10px;
}
.macro{
    margin-top:5px;width:85%;border-radius:5px;padding:5px;display:flex;
}
.msj-rta{
    float:right;background:whitesmoke;
}
.msj{
    float:left;background:white;
}
.frame{
    background:#e0e0de;
    height:450px;
    overflow:hidden;
    padding:0;
}
.frame > div:last-of-type{
    position:absolute;bottom:0;width:100%;display:flex;
}
body > div > div > div:nth-child(2) > span{
    background: whitesmoke;padding: 10px;font-size: 21px;border-radius: 50%;
}
body > div > div > div.msj-rta.macro{
    margin:auto;margin-left:1%;
}
ul {
    width:100%;
    list-style-type: none;
    padding:18px;
    position:absolute;
    bottom:47px;
    display:flex;
    flex-direction: column;
    top:0;
    overflow-y:scroll;
}
.msj:before{
    width: 0;
    height: 0;
    content:"";
    top:-5px;
    left:-14px;
    position:relative;
    border-style: solid;
    border-width: 0 13px 13px 0;
    border-color: transparent #ffffff transparent transparent;            
}
.msj-rta:after{
    width: 0;
    height: 0;
    content:"";
    top:-5px;
    left:14px;
    position:relative;
    border-style: solid;
    border-width: 13px 13px 0 0;
    border-color: whitesmoke transparent transparent transparent;           
}  
input:focus{
    outline: none;
}        
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color: #d4d4d4;
}
::-moz-placeholder { /* Firefox 19+ */
    color: #d4d4d4;
}
:-ms-input-placeholder { /* IE 10+ */
    color: #d4d4d4;
}
:-moz-placeholder { /* Firefox 18- */
    color: #d4d4d4;
}  
</style>
 
    <body>
       
        <div class="col-sm-3 col-sm-offset-4 frame">
            <ul></ul>
            <div>
                <div class="msj-rta macro">                        
                    <div class="text text-r" style="background:whitesmoke !important">
                        <input class="mytext" name="speech-msg" id="speech-msg" x-webkit-speech placeholder="Type a message"/>
                    </div> 

                </div>
                <div style="padding:10px;">
                    <span class="glyphicon glyphicon-share-alt" id="speak"></span>
                </div>                
            </div>
        </div>  

    </body>
      <div id="page-wrapper">
   
  <p id="msg"></p>

  <!-- <input type="text" name="speech-msg" id="speech-msg" x-webkit-speech> -->

    <div class="option">
        <!-- <label for="voice">Voice</label> -->
        <select name="voice" id="voice"></select>
    </div>
    <div class="option">
        <!-- <label for="volume">Volume</label> -->
        <input type="range" min="0" max="1" step="0.1" name="volume" id="volume" value="1">
    </div>
    <div class="option">
        <!-- <label for="rate">Rate</label> -->
        <input type="range" min="0.1" max="10" step="0.1" name="rate" id="rate" value="1">
    </div>
    <div class="option">
        <!-- <label for="pitch">Pitch</label> -->
        <input type="range" min="0" max="2" step="0.1" name="pitch" id="pitch" value="1">
    </div>

    <!-- <button id="speak">Speak</button> -->

</div>
    <script>
         $(document).ready(function(){
           replay="Hello, whats your name ?";
       speak(replay);  
                        $('#voice').hide(); 
                            $('#volume').hide(); 
                                $('#rate').hide(); 
                                    $('#pitch').hide(); 
 
});
        /*
 * Check for browser support
 */
var supportMsg = document.getElementById('msg');
 
if ('speechSynthesis' in window) {
    // supportMsg.innerHTML = 'Your browser <strong>supports</strong> speech synthesis.';
} else {
    supportMsg.innerHTML = 'Sorry your browser <strong>does not support</strong> speech synthesis.<br>Try this in <a href="https://www.google.co.uk/intl/en/chrome/browser/canary.html">Chrome Canary</a>.';
    supportMsg.classList.add('not-supported');
}


// Get the 'speak' button
var button = document.getElementById('speak');

// Get the text input element.
var speechMsgInput = document.getElementById('speech-msg');
 
// Get the voice select element.
var voiceSelect = document.getElementById('voice');

// Get the attribute controls.
var volumeInput = document.getElementById('volume');
var rateInput = document.getElementById('rate');
var pitchInput = document.getElementById('pitch');


// Fetch the list of voices and populate the voice options.
function loadVoices() {
  // Fetch the available voices.
    var voices = speechSynthesis.getVoices();
  
  // Loop through each of the voices.
    voices.forEach(function(voice, i) {
    // Create a new option element.
        var option = document.createElement('option');
    
    // Set the options value and text.
        option.value = voice.name;
        option.innerHTML = voice.name;
          
    // Add the option to the voice selector.
        voiceSelect.appendChild(option);
    });
}

// Execute loadVoices.
loadVoices();

// Chrome loads voices asynchronously.
window.speechSynthesis.onvoiceschanged = function(e) {
  loadVoices();
};


// Create a new utterance for the specified text and add it to
// the queue.
function speak(text) {
  // Create a new instance of SpeechSynthesisUtterance.
    var msg = new SpeechSynthesisUtterance();
  
  // Set the text.
    msg.text = text;
  
  // Set the attributes.
    msg.volume = parseFloat(volumeInput.value);
    msg.rate = parseFloat(rateInput.value);
    msg.pitch = parseFloat(pitchInput.value);
  
  // If a voice has been selected, find the voice and set the
  // utterance instance's voice attribute.
    if (voiceSelect.value) {
        msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == voiceSelect.value; })[0];
    }
  
  // Queue this utterance.
    window.speechSynthesis.speak(msg);
}

 
   
count=0;
// Set up an event listener for when the 'speak' button is clicked.
button.addEventListener('click', function(e) {
    if (speechMsgInput.value.length > 0) {
   if(count==0)
   {
    replay="Awsome , Do you now Every thing  about your  college,Lecturers and Friends";
       speak(replay);
     insertChat("you", "Awsome , Do you now Every thing  about your  college,Lecturers and Friends 'Yes or No'", 1500); 
   }
   else
{
      var str = speechMsgInput.value;
      var res = str.toLowerCase(); 

     if(res=="yes")
    {
     replay="Greate , if u want to get some more knowledge u can get here";
       speak(replay);
     insertChat("you", "Greate , if u want to get some more knowledge u can get here", 1500); 

    }
    else if(res=="no")
    {
     replay="About whome do u want to now, Friends , Lecturers or college";
       speak(replay);
     insertChat("you", "About whome do u want to now, Friends , Lecturers or college", 1500); 
    }

      else if(res=="friends")
    {
     replay="Can u say me the name of student or its pet name";
       speak(replay);
     insertChat("you", "Can u say me the name your Friend or its pet name", 1500); 
    }

      else if(res=="lecturers")
    {
     replay="Can you say which Lecturers information do u want to see";
       speak(replay);
     insertChat("you", "Can you say which Lecturers information do u want to see", 1500); 
    }
      else if(res=="college")
    {
     replay="Surana College has clarity on students’ future, both in their career and life. The institution has many case studies on inducting average students only to raise them to achieve distinction and ranks. The emphasis is on academic focus adding to train for holistic development of students. Constantly identifying value-additions to the university stipulated curriculum, the college designs balanced inputs of curricular and co-curricular components into its practice. Which combination do you want to now in Surana college ? bcome , bba or bca";
       speak(replay);
     insertChat("you", "Surana College has clarity on students’ future, both in their career and life. The institution has many case studies on inducting average students only to raise them to achieve distinction and ranks. The emphasis is on academic focus adding to train for holistic development of students. Constantly identifying value-additions to the university stipulated curriculum, the college designs balanced inputs of curricular and co-curricular components into its practice. Which combination do you want to now Surana college ? BCOM , BBA or BCA", 1500); 
    }
    else if(res=="bcom")
    {
     replay="The Bachelor of Commerce degree is designed to provide the student with a wide range of managerial skills while at the same time building competence in a particular area of business studies. In this stream students are exposed to general business principles, accounting, finance, taxation, human resources, and statistics, marketing, banking, economics and information systems. One can pursue B.Com and shape a career in various sectors like banking, financial services, business and industry, government services and law. B.Com also opens doors for Master in Business Administration and M.Com.";
       speak(replay);
     insertChat("you", "The Bachelor of Commerce degree is designed to provide the student with a wide range of managerial skills while at the same time building competence in a particular area of business studies. In this stream students are exposed to general business principles, accounting, finance, taxation, human resources, and statistics, marketing, banking, economics and information systems. One can pursue B.Com and shape a career in various sectors like banking, financial services, business and industry, government services and law. B.Com also opens doors for Master in Business Administration and M.Com.", 1500); 
    }
    else if(res=="bca")
    {
     replay="The BCA programme provides student with necessary skill to make successful career as IT professional in competitive situationwith satisfying jobs. It also prepares students with the requisite background to proceed with confidence for higher studies in theform of MCA, MIT, MS in computers, MBA, etc, and thus acquire greater competency.";
       speak(replay);
     insertChat("you", "The BCA programme provides student with necessary skill to make successful career as IT professional in competitive situationwith satisfying jobs. It also prepares students with the requisite background to proceed with confidence for higher studies in theform of MCA, MIT, MS in computers, MBA, etc, and thus acquire greater competency.", 1500); 
    }
    else if(res=="bba")
    {
     replay="The Bachelor of Business Administration (BBA) programme aims at developing professionally groomed students who have schooling in a diverse range of subject areas. Students will master the fundamentals of business management and leadership, and in the process, gain insights into the major areas of global business. Students choose a major from three business specializations (finance, marketing and HR). A distinctive feature of BBA at Surana College is the prestigious and highly competitive in the education domain.";
       speak(replay);
     insertChat("you", "The Bachelor of Business Administration (BBA) programme aims at developing professionally groomed students who have schooling in a diverse range of subject areas. Students will master the fundamentals of business management and leadership, and in the process, gain insights into the major areas of global business. Students choose a major from three business specializations (finance, marketing and HR). A distinctive feature of BBA at Surana College is the prestigious and highly competitive in the education domain.", 1500); 
    }

 }      // speak(speechMsgInput.value);
count++;
    }
});

    </script>
    <script>
        var me = {};
me.avatar = "https://lh6.googleusercontent.com/-lr2nyjhhjXw/AAAAAAAAAAI/AAAAAAAARmE/MdtfUmC0M4s/photo.jpg?sz=48";

var you = {};
you.avatar = "https://a11.t26.net/taringa/avatares/9/1/2/F/7/8/Demon_King1/48x48_5C5.jpg";

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}            

//-- No use time. It is a javaScript effect.
function insertChat(who, text, time){
    if (time === undefined){
        time = 0;
    }
    var control = "";
    var date = formatAMPM(new Date());
    
    if (who == "me"){
        control = '<li style="width:100%">' +
                        '<div class="msj macro">' +
                        '<div class="avatar"><img class="img-circle" style="width:100%;" src="'+ me.avatar +'" /></div>' +
                            '<div class="text text-l">' +
                                '<p>'+ text +'</p>' +
                                '<p><small>'+date+'</small></p>' +
                            '</div>' +
                        '</div>' +
                    '</li>';                    
    }else{
        control = '<li style="width:100%;">' +
                        '<div class="msj-rta macro">' +
                            '<div class="text text-r">' +
                                '<p>'+text+'</p>' +
                                '<p><small>'+date+'</small></p>' +
                            '</div>' +
                        '<div class="avatar" style="padding:0px 0px 0px 10px !important"><img class="img-circle" style="width:100%;" src="'+you.avatar+'" /></div>' +                                
                  '</li>';
    }
    setTimeout(
        function(){                        
            $("ul").append(control).scrollTop($("ul").prop('scrollHeight'));
        }, time);
    
}

function resetChat(){
    $("ul").empty();
}

$(".mytext").on("keydown", function(e){
    if (e.which == 13){
        var text = $(this).val();
        if (text !== ""){
            insertChat("me", text);              
            $(this).val('');
        }
    }
});

$('body > div > div > div:nth-child(2) > span').click(function(){
    $(".mytext").trigger({type: 'keydown', which: 13, keyCode: 13});
})

//-- Clear Chat
resetChat();

//-- Print Messages
insertChat("you", "Whats your name ?", 0);  
// insertChat("you", "junaid", 1500);
// insertChat("me", "What would you like to talk about today?", 3500);
// insertChat("you", "Tell me a joke",7000);
// insertChat("me", "Spaceman: Computer! Computer! Do we bring battery?!", 9500);
// insertChat("you", "LOL", 12000);


//-- NOTE: No use time on insertChat.
    </script>
</html>
