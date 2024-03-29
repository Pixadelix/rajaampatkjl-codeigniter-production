w = window;
n = w.innerWidth;
m = w.innerHeight;
d = document;
q = "px";

function z(a, b) {
    return Math.floor(Math.random() * (b - a) + a)
}
f = "0123456789";

for (i = 0; i < 45; i++) {
	f += String.fromCharCode(i + 65393);
}

function matrix_rain() {
    for (i = 0; i < 90; i++) {
        r = d.createElement("div");
        r.className = 'matrix';
        for (j = z(20, 60); j; j--) {
            x = d.createElement("pre");
            y = d.createTextNode(f[z(0, 46)]);
            x.appendChild(y);
            x.style.opacity = 0;
            r.appendChild(x)
        }
        r.id = "r" + i;
        r.t = z(-99, 0);
        with(r.style) {
            left = z(0, n) + q;
            top = z(-m, 0) + q;
            fontSize = z(10, 25) + q;
        }
        d.body.appendChild(r);
        setInterval("u(" + i + ")", z(20, 30));
    }
}

function u(j) {
    e = d.getElementById("r" + j);
    c = e.childNodes;
    t = e.t + 1;
    if ((v = t - c.length - 60) > 0) {
        if ((e.style.opacity = 1 - v / 32) == 0) {
            for (f in c)
                if (c[f].style) c[f].style.opacity = 0;
            with(e.style) {
                left = z(0, n) + q;
                top = z(-m / 2, m / 2) + q;
				//console.log('moving to '+left+', '+top);
                opacity = 1
            }
            t = -1;
        }
    }
    e.t = t;
    if (t < 0 || t > c.length + 12) return;
    for (f = t; f && f > t - 12; f--) {
        s = 1 - (t - f) / 16;
        if (f < c.length && c[f].style) {
            c[f].style.opacity = s;
        }
    }
}

matrix_rain();
