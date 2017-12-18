<html><head>
<style type="text/css">

body {
    background-color: #ddd;
    font-size: 100%;
    padding: 3em;
}
.mainNav {
    float: left;
    transform: perspective(500px);
    transform-style: preserve-3d;
}
.mainNav ul {
  list-style: none;
  padding: 0;
}
.mainNav a {
    background-color: #6cf;
    background-image: linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.05)),
                      linear-gradient(-72deg, hsla(0,0%,100%,.05) 50%, transparent 50%);
    backface-visibility: hidden;
    box-shadow: inset 0 0 .25em hsla(0,0%,0%,.1),
                inset 0 0 1.5em hsla(0,0%,0%,.25);
    color: #333;
    display: block;
    font: bold 1em/3 sans-serif;
    padding: 0 1.5em;
    position: relative;
    text-align: center;
    text-decoration: none;
    text-shadow: 0 1px 1px hsla(0,0%,100%,.25);
    transition: .5s;
    transform-origin: 50% 0;
    transform-style: preserve-3d;
    width: 6em;
}
.mainNav a:after {
    background-color: inherit;
    background-image: linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.05)),
                      linear-gradient(-72deg, hsla(0,0%,100%,.05) 50%, transparent 50%),
                      linear-gradient(hsla(0,0%,0%,.25), hsla(0,0%,0%,.25));
    box-shadow: inset 0 0 .25em hsla(0,0%,0%,.2),
                inset 0 0 1.5em hsla(0,0%,0%,.3);
    bottom: 0;
    color: #fff;
    content: attr(data-title);
    left: 100%;
    line-height: 3;
    position: absolute;
    top: 0;
    transform: rotateY(90deg);
    transform-origin: 0 0;
    width: 100%;
}
.mainNav a:before {
    background-color: inherit;
    background-image: linear-gradient(hsla(0,0%,100%,.07), hsla(0,0%,0%,.07)),
                      linear-gradient(hsla(0,0%,0%,.5), hsla(0,0%,0%,.5));
    bottom: 0;
    content: '';
    height: 9em;
    left: 100%;
    position: absolute;
    top: 0;
    transform-origin: 0 0;
    width: 100%;
}
.mainNav li:nth-child(-n+2) a:before {
    transform: rotateX(-90deg) translateX(-9em) translateZ(3em);
}
.mainNav li:nth-child(n+3) a:before {
    transform: rotateX(-90deg) translateX(-9em);
}
.mainNav li:hover a {
    transform: rotateY(-90deg) translateX(-4.5em) translateZ(4.5em);
    z-index: 10;
}
</style>
</head>
<body>
<nav class="mainNav">
    <ul>
        <li><a href="#" data-title="Home">Home</a></li>
        <li><a href="#" data-title="About">About</a></li>
        <li><a href="#" data-title="Clients">Clients</a></li>
        <li><a href="#" data-title="Work">Work</a></li>
        <li><a href="#" data-title="Contact Us">Contact Us</a></li>
    </ul>
</nav></body></html>