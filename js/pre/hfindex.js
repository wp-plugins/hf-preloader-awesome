//laggy? Turn down partNum
var partNum = 100;

var canvas = document.getElementById('c');
var ctx = canvas.getContext('2d');

var w = window.innerWidth; var h = window.innerHeight;
var x = 100; var y = 100;

var particles = [];
for(i = 0; i < partNum; i++) {
  particles.push(new newParticle);
}

function newParticle() {
  this.x = w / 2;
  this.y = h / 2;
  
  this.vx = Math.random() * 20 - 10;
  this.vy = Math.random() * 20 - 10;
  
  this.r = Math.random() * 15;
  
  var r = '#c0392b';
  var o = '#e67e22';
  var y = '#f1c40f';
  var array = [r, o, y];
	this.color = array[Math.floor(Math.random() * 3)];
  
  this.g = 0.3; 
}

var draw = function() {
  c.width = w;
  c.height = h;
  
  for(t = 0; t < particles.length; t++) {
    var p = particles[t];
    
    ctx.beginPath();
  	ctx.fillStyle = p.color;
  	ctx.arc(p.x, p.y, p.r, Math.PI * 2, false);
  	ctx.fill();
    
    p.x+=p.vx;
    p.y+=p.vy+=p.g;
    
    if(p.y < 0)
      p.vy *= -1;
    if(p.y > h)
      p.vy *= -1;
      p.vy -= -0.5;
    if(p.y > h + 1)
      p.y = h;
    if(p.x < 0)
      p.vx *= -1;
    if(p.x > w)
      p.vx *= -1;
    if(p.r < 3) {
      p.color = 'white';
    };
  }
};

setInterval(draw, 33);