<html>


<head>


	<meta name="viewport" content="width=device-width, initial-scale=1.0">


  <title>PlayMe</title>



<style>
  .center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
  } 
  
@keyframes ani {
  0% {left: 0; top: 0; opacity: 1; font-size: 12px; }
  50% {left: -32px; top: -100; opacity: 1; font-size: 64px; }
  100% {left: -32px; top: -100; opacity: 0; font-size: 64px; }
}  

.slapani {
  position: absolute;
  animation: ani 2s forwards;
  color: red;
}

.clapani {
  position: absolute;
  animation: ani 2s forwards;
  color: blue;
}
</style>


</head>


<body>

  <center>

		<a href="index.php">Home</a><br><br>




    <audio id="audio" autoplay></audio>
    <div id="title"></div>
    <div id="items"></div>
    <marquee style="width:300px;display:block;"><div id="playing">
      Please Load Playlist
    </div>
    </marquee>
    <a href="javascript:audio.play();">play</a>
    <a href="javascript:audio.pause();">pause</a>
    <a href="javascript:audio.pause();audio.currentTime=0;seek_slider.value=0;">stop</a>
    <a href="javascript:prev();">prev</a>
    <a href="javascript:next();">next</a>
    <a href="javascript:shuffle(urls);index=0;play(index);">shuffle</a>
 
    <br><br>
 
    <input type="range" min="1" max="100" value="0" id="seek_slider" onchange="seekTo()">

    <br><br>

<!--

		<input id="playlist" type="url" placeholder="playlist url">

		<button onclick="loadPlaylist()">Load</button>
		<button onclick="savePlaylist()">Save</button>

-->

<a href="javascript:hate()" style="text-decoration:none;color:red;margin-right:75px;font-size:32px;">slap</a>

<a href="javascript:like()" style="text-decoration:none;color:blue;margin-left:75px;font-size:32px;">clap</a>

<br><br>


		    
  </center>





<div class="center">
  <div id="count" style="font-size:64px;left:0;top:64px;position:relative;"></div>
</div>

<div id="container" class="center"></div>







  <script>

    var audio = document.getElementById("audio");
    var items = document.getElementById("items");
    var playing = document.getElementById("playing");
// 	  var playlist = document.getElementById("playlist");
    var seek_slider = document.getElementById("seek_slider");
    var index = 0;

    var urls = null;

		var currentId=0;

  var container=document.getElementById("container");
  var count=document.getElementById("count");
  var clapCnt=0;
  var slapCnt=0;
  var lto=null;
  var hto=null;




    function getFilename(fullPath) {
      if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\'): fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
          filename = filename.substring(1);
        }
        filename = filename.substring(0, filename.lastIndexOf('.'));
        return filename;
      }
    }

    function shuffle(array) {
      let currentIndex = array.length,
      randomIndex;
      while (currentIndex != 0) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;
        [array[currentIndex],
          array[randomIndex]] = [array[randomIndex],
          array[currentIndex]];
      }
      return array;
    }

    function play(index) {
      items.textContent = (index+1)+"/"+(urls.length);
      playing.textContent = getFilename(urls[index]);
      audio.src = urls[index];
      audio.play();
      seek_slider.value = 0;
    }

    function prev() {
      index = index-1 < 0?urls.length-1: index-1;
      play(index);
    };

    function next() {
      index = (index+1)%urls.length;
      play(index);
    };

    function seekTo() {
      audio.currentTime = audio.duration * (seek_slider.value / 100);
    }

    function seekUpdate() {
      if (!isNaN(audio.duration)) {
        seek_slider.value = audio.currentTime * (100 / audio.duration);
      }
    }


	function removeEmptyLines(lines) {
		var result=[]
		for (var i = 0; i < lines.length; i++) {
			if(lines[i].trim() !== '') {
				result.push(lines[i].trim());
			}
		}
		return result;
	}



function savePlaylist() {
	if(playlist.value) {
    var data={playlist: playlist.value};
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "save.php");
		xhr.onreadystatechange = function() { 
			if(this.readyState == 4 && this.status == 200) {
		 		var data=JSON.parse(this.responseText);
				if(data.status==="OK") {
					alert("Successfully saved.");
				} else {
					alert("Error saving.");
				}
			}
		}
		xhr.setRequestHeader("Content-type", "application/json");
		xhr.send(JSON.stringify(data));
	} else {
		alert("Error saving.");
	}
}

function getPlaylist(url,cb) {
  var client = new XMLHttpRequest();
  client.open('GET', url, true);
  client.onreadystatechange = function() {
    if (client.readyState === 4 && client.status === 200) {
      cb(this.responseText);
    }
  }
  client.send();
}

function loadPlaylist() {
	getPlaylist(playlist.value,function(data) {
		title.textContent=getFilename(playlist.value);
		urls=removeEmptyLines(data.split("\n"));
		play(0);
	});
}

function load(id) {
	var xhr = new XMLHttpRequest();
	xhr.open("GET","load.php?id="+id,true);
	xhr.onreadystatechange = function() { 
		if(this.readyState == 4 && this.status == 200) {
			var data1=JSON.parse(this.responseText);

			currentId=id;

			title.textContent=getFilename(data1.playlist);
			getPlaylist(data1.playlist,function(data2) {
				title.textContent=getFilename(data1.playlist);
				urls=removeEmptyLines(data2.split("\n"));
				play(0);
			});
		}
	}
	xhr.send();
}





 function enluv(n) {
    var c="iloveu";
    var b=c.length;
    var v="";
    var i=0;
    var s="p";
    if(n<0) { n=-n; s="n"; }
    do {
      v=c.charAt(n%b)+v;
      n=Math.floor(n/b);
    } while(n);
    return s+v;
  }
  
  function deluv(n) {
    var c="iloveu";
    var b=c.length;
    var v=0;
    var i=n.length-1;
    var j=1;
    var s=1;
    if(n.charAt(0)==="n") s=-1; 
    while(i>=1) {
      v+=c.indexOf(n.charAt(i--))*j;
      j*=b;
    }
    return s*v;
  }
 



function karma(cnt) {
	var xhr = new XMLHttpRequest();
	xhr.open("GET","karma.php?id="+currentId+"&karma="+cnt+"&code="+enluv(cnt),true);
	xhr.onreadystatechange = function() { 
	}
	xhr.send();	
}




  
  function remove(id) {
    setTimeout(function() {
      container.removeChild(document.getElementById(id));
    },1000);    
  }
  
  function like() {

    if(hto!==null) return;

    if(lto) {
      clearTimeout(lto);
    }
    
    lto=setTimeout(function() {
			karma(clapCnt);
      clapCnt=0;
      count.textContent="";
      lto=null;
    },2000);

    clapCnt++;
    
    container.insertAdjacentHTML(
      "beforeend",
      "<span class='clapani' id='clap"+clapCnt+"'>clap</span>"
    );

    remove("clap"+clapCnt);
    
    count.innerHTML="<font color='blue'>+"+clapCnt+"</font>";
 }
  
  
 function hate() {
   
    if(lto!==null) return;
    
    if(hto) {
      clearTimeout(hto);
    }
    
    hto=setTimeout(function() {
			karma(slapCnt);
      slapCnt=0;
      count.textContent="";
      hto=null;
    },2000);
  
    slapCnt--;
  
    container.insertAdjacentHTML(
      "beforeend",
      "<span class='slapani' id='slap"+slapCnt+"'>slap</span>"
    );

    remove("slap"+slapCnt);
    
    count.innerHTML="<font color='red'>"+slapCnt+"</font>";
  }




    audio.onended = next;
    setInterval(seekUpdate, 1000);


<?php
		if(isset($_GET['id'])) echo "load(\"".$_GET['id']."\");"		
?>


  </script>

</body>
</html>
