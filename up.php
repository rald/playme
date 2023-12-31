<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlayMe</title>
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

		<input id="playlist" type="url" placeholder="playlist url">

		<button onclick="loadPlaylist()">Load</button>
		<button onclick="savePlaylist()">Save</button>
		    
  </center>



  <script>

    var audio = document.getElementById("audio");
    var items = document.getElementById("items");
    var playing = document.getElementById("playing");
 	  var playlist = document.getElementById("playlist");
    var seek_slider = document.getElementById("seek_slider");
    var index = 0;

    var urls = null;

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

    audio.onended = next;
    setInterval(seekUpdate, 1000);


<?php
		if(isset($_GET['id'])) echo "load(\"".$_GET['id']."\");"		
?>


  </script>

</body>
</html>
