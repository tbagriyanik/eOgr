// Parse URLs to links
function autoLinks(msg) {

  var text = msg.replace(/((?:ht|f)tps?:\/\/([^\s,]*))/gi,
  "<a href='$1' target='_blank'><span class=\"blue\">$1</span></a>");
  
  return text;

}


// Split too long lines
function splitMsg(msg) {

  var text = msg.replace(/(.[^\s\<\>]{15})/gi,
  "$1\n");

  return text;

}


// Replace smileys tags with images
function replaceSmileys(message) {
  
  var sm = message.replace(/(:\)|:\-\))/g, "<img src='lib/wtag/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' />").
  replace(/(:\(|:-\()/g, "<img src='lib/wtag/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' />").
  replace(/(\;\)|\;\-\))/g, "<img src='lib/wtag/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' />").
  replace(/(:-P)/g, "<img src='lib/wtag/smileys/tongue.gif' width='15' height='15' alt=':-P' title=':-P' />").
  replace(/(S\-\))/g, "<img src='lib/wtag/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' />").
  replace(/(]\()/g, "<img src='lib/wtag/smileys/angry.gif' width='15' height='15' alt='](' title='](' />").
  replace(/(\:\*\))/g, "<img src='lib/wtag/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' />").
  replace(/(\:-D)/g, "<img src='lib/wtag/smileys/grin.gif' width='15' height='15' alt=':-D' title=':-D' />").
  replace(/(QQ)/g, "<img src='lib/wtag/smileys/cry.gif' width='15' height='15' alt='QQ' title='QQ' />").
  replace(/(\=O)/g, "<img src='lib/wtag/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' />").
  replace(/(\=\/)/g, "<img src='lib/wtag/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' />").
  replace(/(8\-\))/g, "<img src='lib/wtag/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' />").
  replace(/(:-X)/g, "<img src='lib/wtag/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' />").
  replace(/(O:\])/g, "<img src='lib/wtag/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' />");
  
  return sm;

}


// Add a smiley tag to a message
function tagSmiley(tag) {
  
  var chat_message = document.getElementById('message');
  
  if (chat_message.value == "mesaj")
  {
  chat_message.value = '';
  }
  
  var cache = chat_message.value;
  this.tag = tag;
  chat_message.value = cache + tag;

}


// Clear default value of the name field
// + change the name field text color
function set_focus_n(t) {

  if (t.defaultValue == t.value)
  t.value = '';
  t.style.color = '#000000';

}


// Change the url field text color
function set_focus_u(t) {

  t.style.color = '#000000';

}


// Clear default value of the message field
// + change the message field text color
function set_focus_m(t) {

  if (t.defaultValue == t.value)
  t.value = '';
  t.style.color = 'blue';

}


// Submit on Enter key press
// The function taken from http://www.ryancooper.com/resources/keycode.asp
function checkKeycode(e) {
  
  var keycode;
  
  if (window.event) keycode = window.event.keyCode;
  else if (e) keycode = e.which;
  
  if(keycode == 13)
  {
  sendMessage();
  return false;
  }
  else return true;

}


// Replace bad words with symbols
function filterBW(message) {
  
  for (var i=0; i < badwords.length; i++) {
  var pattern=new RegExp("\\b("+badwords.join("|")+"){1,}\\b",'gi');
  var replacement = "*!#?*";
  text = message.replace(pattern,replacement);
  }
  
  return text;

}


// Validate user input and alert if something goes wrong
function checkInput(name, url, message) {
  
  var input_e = "";
  
  input_e += checkName(name);
  input_e += checkUrl(url);
  input_e += checkMessage(message);
  input_e += checkChars(name);
  input_e += checkChars(url);
  input_e += checkChars(message);
  input_e += checkSpam(name);
  input_e += checkSpam(url);
  input_e += checkSpam(message);
  
  if (input_e != "")
  {
  alert(input_e);
  return false;
  }

  return true;

}


// Check for restricted tags and attributes
function checkChars(msg) {
  
  var error = "";
  
  for (var i=0; i < characters.length; i++) { 
  
  if (msg.indexOf(characters[i])!= -1)
  { 
  error = "'http://' ile adres gönderebilirsiniz. Diger etiketler kullanilamaz!\n";
  } 
  
  } 
  
  return error;

} 


// Check a message against the banned words list
function checkSpam(msg) {
  
  var error = "";
  
  for (var i=0; i < spamwords.length; i++) {
  
  var pattern = new RegExp("\\b("+spamwords.join("|")+"){1,}\\b",'gi');       
  
  if (pattern.test(msg))
  { 
  error = "Yasak kelime kullandiniz.\n";
  }
  } 

  return error;

} 
 

// Validate a name
function checkName(name) {
  
  var error="";
  
  if (name == "" || name == "name")
  {
  error = "Adiniz bos olamaz.\n";
  }
  
  for (var i=0; i < badwords.length; i++) {
  var pattern = new RegExp("\\b("+badwords.join("|")+"){1,}\\b",'gi');
  if ((name.length > 30)||(pattern.test(name)))
  { 
   error = "Adiniz cok uzun.\n";
  }
  } 

  return error;

}
 
 
// Validate a message
function checkMessage(message) {
  
  var error="";
  
  if (message=="" || message=="mesaj")
  {
  error = "Mesaj bos olamaz!\n";
  }
  
  if (message.length > 400)
  {
  error = "Mesaj 400 karakterden fazla olamaz!\n";
  }
  
  return error;

}
 

// Validate a URL
function checkUrl(url) {
  
  var error="";     

  var pattern=new RegExp("((?:ht|f)tps?://.*?)([^\s,]*)\.([^\s,]*)",'gi');
  
  if (!(url=="" || url=="http://"))
  {
  if ((url.length>100)||(!pattern.test(url)))
  { 
  error = "Hatali adres girildi.\n";
  } 
  }

  return error;

}


/*------ AJAX part -----------------------------------------------------------*/

/*
* The Ajax part of the shoutbox script is based on AJAX-Based Chat System
* by Alejandro Gervasio
* URL: http://images.devshed.com/da/stories/Building_AJAX_Chat/chat_example.zip
*/

// Create the XMLHttpRequestObject
function getXMLHttpRequestObject() {
  var xmlobj;	
  // Check for existing requests
  if (xmlobj!=null&&xmlobj.readyState!=0&&xmlobj.readyState!=4) {
  xmlobj.abort();
  }
  try {
  // Instantiate object for Mozilla, Nestcape, etc.
  xmlobj=new XMLHttpRequest();
  }
  catch(e) {
  try {
  // Instantiate object for Internet Explorer
  xmlobj=new ActiveXObject('Microsoft.XMLHTTP');
  }
  catch(e) {
  // Ajax is not supported by the browser
  xmlobj=null;
  return false;
  }
  }
  return xmlobj;
}



// Check status of sender object
function senderStatusChecker() {
  // Check if request is completed
  if(senderXMLHttpObj.readyState==4) {
  if(senderXMLHttpObj.status==200) {
 
  // If status == 200 display chat data
  displayChatData(senderXMLHttpObj);
  }
  else {
  var post=document.getElementById('content');
  var error_message = document.createTextNode('Cevap YOK :'+ senderXMLHttpObj.statusText);
  post.appendChild(error_message);
  }
  }
}


// Check status of receiver object
function receiverStatusChecker() {
  // If request is completed
  if(receiverXMLHttpObj.readyState==4) {
  if(receiverXMLHttpObj.status==200) {
  // If status == 200 display chat data
  displayChatData(receiverXMLHttpObj);
  }
  else {
  var post=document.getElementById('content');
  var error_message = document.createTextNode('Cevap YOK! :'+ receiverXMLHttpObj.statusText);
  post.appendChild(error_message);
  }
  }
}


// Get messages from database each 5 seconds
function getChatData() {
  receiverXMLHttpObj.open('GET','lib/wtag/getchat.php',true);
  receiverXMLHttpObj.onreadystatechange=receiverStatusChecker;
  receiverXMLHttpObj.send(null);
  setTimeout('getChatData()',2000);
  
}


// instantiate sender XMLHttpRequest object
var senderXMLHttpObj = getXMLHttpRequestObject();
// instantiate receiver XMLHttpRequest object
var receiverXMLHttpObj = getXMLHttpRequestObject();

 
// Display messages
function displayChatData(reqObj) {
  
  var post=document.getElementById('content');
  
  if(!post)
  {
  return;
  }
  post.innerHTML = '';

  var xmldoc = receiverXMLHttpObj.responseXML;
  var message_nodes = xmldoc.getElementsByTagName('msg');
  
  for (i = 0; i < message_nodes.length; i++) {
  
  var date = message_nodes[i].getElementsByTagName('date');
  var name = message_nodes[i].getElementsByTagName('name');
  var url = message_nodes[i].getElementsByTagName('url');
  var message = message_nodes[i].getElementsByTagName('message');
 
  var user = document.createElement('div');
  
  user.className = 'user';
  
  var slink = document.createElement('span');
  slink.className = 'link';
  
  var sname = document.createElement('span');
  sname.className = 'name';
  
  var name = document.createTextNode(name[0].firstChild.nodeValue);
  sname.appendChild(name);
  
  if (url.length && url[0].firstChild)
  {
  var usr = document.createElement('a');
  usr.href = url[0].firstChild.nodeValue;
  usr.title = url[0].firstChild.nodeValue;
  usr.target = "_blank";
  usr.appendChild(name);
  slink.appendChild(usr);  
  }
  else
  {
  slink = sname;
  }
  
  var maintext = document.createElement('span');
  maintext.className='text';
  if (sm_options == 'yes')
  {
  var text = splitMsg(filterBW(autoLinks(replaceSmileys(message[0].firstChild.nodeValue))));
  }
  else
  {
  var text = splitMsg(filterBW(autoLinks(message[0].firstChild.nodeValue)));
  }
  
  maintext.innerHTML += text;
  
  var sdate = document.createElement('span');
  sdate.className='date';
  
  var spl=date[0].firstChild.nodeValue.split(" ");
  var nd = spl[0].substring(0,10);
  var nt = spl[1].substring(0,5);
  var newtime= document.createTextNode(nt);
  
  sdate.title = nd;
  sdate.appendChild(newtime);
  
  user.appendChild(sdate);
  user.appendChild(slink);
  user.appendChild(maintext);                   
  
  post.appendChild(user);
  
  scroller.init();
 
}

}


// Send a message
function sendMessage() {
  
  var token = document.getElementById('token').value;
  var name = document.getElementById('name').value;
  var url = document.getElementById('url').value;
  var message = document.getElementById('message').value;
  
  if (!checkInput(name, url, message))
  {
  return;
  }
  
  senderXMLHttpObj.open('POST','lib/wtag/sendchat.php',true);
  senderXMLHttpObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  senderXMLHttpObj.send('token='+token+'&name='+encodeURIComponent(name)+'&url='+encodeURIComponent(url)+'&message='+encodeURIComponent(message));
  
  senderXMLHttpObj.onreadystatechange = senderStatusChecker;
  
  var post = document.getElementById('content');
  var scrollbar = document.getElementById('scroller')
  post.style.position = 'absolute';
  post.style.top = '0px';
  post.style.bottom = '0px';
  post.style.position = 'relative';
  scrollbar.style.top="0px";
  document.getElementById('url').value = 'http://';
  document.getElementById('message').value = '';
  document.getElementById('message').focus();
  
}


// Initialize chat 
function startChat() {
  
  var cform = document.getElementById('cform');
  var name = document.getElementById('name');
  var url = document.getElementById('url');
  var msg = document.getElementById('message');
  var submit = document.getElementById('submit');
  var smiley_box = document.getElementById('smiley_box');
  
  var refresh = document.getElementById('refresh');
  
  if (sm_options == 'no') {
  
  smiley_box.style.display = "none";
  
  }
  
  cform.onkeydown = checkKeycode;
 // name.onfocus = function () {set_focus_n(this);}
 // url.onfocus = function () {set_focus_u(this);}
  msg.onfocus = function () {set_focus_m(this);}
  submit.onclick = sendMessage;
  
  refresh.onclick = function () {
  
  getChatData();
  
  }
  
 // name.value = 'name';
  url.value = 'http://';
  msg.value = 'mesaj';
  
  getChatData();
  startList();
  
}


window.onload = startChat;
