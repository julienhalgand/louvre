/*! modernizr 3.5.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-inputtypes-svg-setclasses !*/
! function(e, t, n) {
    function a(e, t) { return typeof e === t }

    function s() { var e, t, n, s, o, i, c; for (var u in r)
            if (r.hasOwnProperty(u)) { if (e = [], t = r[u], t.name && (e.push(t.name.toLowerCase()), t.options && t.options.aliases && t.options.aliases.length))
                    for (n = 0; n < t.options.aliases.length; n++) e.push(t.options.aliases[n].toLowerCase()); for (s = a(t.fn, "function") ? t.fn() : t.fn, o = 0; o < e.length; o++) i = e[o], c = i.split("."), 1 === c.length ? Modernizr[c[0]] = s : (!Modernizr[c[0]] || Modernizr[c[0]] instanceof Boolean || (Modernizr[c[0]] = new Boolean(Modernizr[c[0]])), Modernizr[c[0]][c[1]] = s), l.push((s ? "" : "no-") + c.join("-")) } }

    function o(e) { var t = u.className,
            n = Modernizr._config.classPrefix || ""; if (f && (t = t.baseVal), Modernizr._config.enableJSClass) { var a = new RegExp("(^|\\s)" + n + "no-js(\\s|$)");
            t = t.replace(a, "$1" + n + "js$2") }
        Modernizr._config.enableClasses && (t += " " + n + e.join(" " + n), f ? u.className.baseVal = t : u.className = t) }

    function i() { return "function" != typeof t.createElement ? t.createElement(arguments[0]) : f ? t.createElementNS.call(t, "http://www.w3.org/2000/svg", arguments[0]) : t.createElement.apply(t, arguments) } var l = [],
        r = [],
        c = { _version: "3.5.0", _config: { classPrefix: "", enableClasses: !0, enableJSClass: !0, usePrefixes: !0 }, _q: [], on: function(e, t) { var n = this;
                setTimeout(function() { t(n[e]) }, 0) }, addTest: function(e, t, n) { r.push({ name: e, fn: t, options: n }) }, addAsyncTest: function(e) { r.push({ name: null, fn: e }) } },
        Modernizr = function() {};
    Modernizr.prototype = c, Modernizr = new Modernizr, Modernizr.addTest("svg", !!t.createElementNS && !!t.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect); var u = t.documentElement,
        f = "svg" === u.nodeName.toLowerCase(),
        p = i("input"),
        d = "search tel url email datetime date month week time datetime-local number range color".split(" "),
        m = {};
    Modernizr.inputtypes = function(e) { for (var a, s, o, i = e.length, l = "1)", r = 0; i > r; r++) p.setAttribute("type", a = e[r]), o = "text" !== p.type && "style" in p, o && (p.value = l, p.style.cssText = "position:absolute;visibility:hidden;", /^range$/.test(a) && p.style.WebkitAppearance !== n ? (u.appendChild(p), s = t.defaultView, o = s.getComputedStyle && "textfield" !== s.getComputedStyle(p, null).WebkitAppearance && 0 !== p.offsetHeight, u.removeChild(p)) : /^(search|tel)$/.test(a) || (o = /^(url|email)$/.test(a) ? p.checkValidity && p.checkValidity() === !1 : p.value != l)), m[e[r]] = !!o; return m }(d), s(), o(l), delete c.addTest, delete c.addAsyncTest; for (var g = 0; g < Modernizr._q.length; g++) Modernizr._q[g]();
    e.Modernizr = Modernizr }(window, document);