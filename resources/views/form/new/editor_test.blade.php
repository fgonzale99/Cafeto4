<!DOCTYPE html>
<html lang="es">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="uEtQM11nFX9A8A7V4SUaWkTgw0W5cPYYOmljmZa1">




    <title>
        Cafeto </title>




    <link rel="stylesheet" href="http://127.0.0.1:8000/vendor/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/vendor/fontawesome-free/css/all.min.css">





    <link rel="stylesheet" href="/js/datepicker-js/datepicker.min.css">



































    <link rel="stylesheet" href="/css/framework.css">





















    <link rel="stylesheet" href="/css/bs-stepper.css">




























    <link rel="stylesheet" href="/css/avanciencia.css">























    <link rel='stylesheet' type='text/css' property='stylesheet' href='//127.0.0.1:8000/_debugbar/assets/stylesheets?v=1675524420&theme=auto' data-turbolinks-eval='false' data-turbo-eval='false'>
    <script src='//127.0.0.1:8000/_debugbar/assets/javascript?v=1675524420' data-turbolinks-eval='false' data-turbo-eval='false'></script>
    <script data-turbo-eval="false">
        jQuery.noConflict(true);
    </script>
    <script>
        Sfdump = window.Sfdump || (function(doc) {
            var refStyle = doc.createElement('style'),
                rxEsc = /([.*+?^${}()|\[\]\/\\])/g,
                idRx = /\bsf-dump-\d+-ref[012]\w+\b/,
                keyHint = 0 <= navigator.platform.toUpperCase().indexOf('MAC') ? 'Cmd' : 'Ctrl',
                addEventListener = function(e, n, cb) {
                    e.addEventListener(n, cb, false);
                };
            refStyle.innerHTML = '.phpdebugbar pre.sf-dump .sf-dump-compact, .sf-dump-str-collapse .sf-dump-str-collapse, .sf-dump-str-expand .sf-dump-str-expand { display: none; }';
            doc.head.appendChild(refStyle);
            refStyle = doc.createElement('style');
            doc.head.appendChild(refStyle);
            if (!doc.addEventListener) {
                addEventListener = function(element, eventName, callback) {
                    element.attachEvent('on' + eventName, function(e) {
                        e.preventDefault = function() {
                            e.returnValue = false;
                        };
                        e.target = e.srcElement;
                        callback(e);
                    });
                };
            }

            function toggle(a, recursive) {
                var s = a.nextSibling || {},
                    oldClass = s.className,
                    arrow, newClass;
                if (/\bsf-dump-compact\b/.test(oldClass)) {
                    arrow = '▼';
                    newClass = 'sf-dump-expanded';
                } else if (/\bsf-dump-expanded\b/.test(oldClass)) {
                    arrow = '▶';
                    newClass = 'sf-dump-compact';
                } else {
                    return false;
                }
                if (doc.createEvent && s.dispatchEvent) {
                    var event = doc.createEvent('Event');
                    event.initEvent('sf-dump-expanded' === newClass ? 'sfbeforedumpexpand' : 'sfbeforedumpcollapse', true, false);
                    s.dispatchEvent(event);
                }
                a.lastChild.innerHTML = arrow;
                s.className = s.className.replace(/\bsf-dump-(compact|expanded)\b/, newClass);
                if (recursive) {
                    try {
                        a = s.querySelectorAll('.' + oldClass);
                        for (s = 0; s < a.length; ++s) {
                            if (-1 == a[s].className.indexOf(newClass)) {
                                a[s].className = newClass;
                                a[s].previousSibling.lastChild.innerHTML = arrow;
                            }
                        }
                    } catch (e) {}
                }
                return true;
            };

            function collapse(a, recursive) {
                var s = a.nextSibling || {},
                    oldClass = s.className;
                if (/\bsf-dump-expanded\b/.test(oldClass)) {
                    toggle(a, recursive);
                    return true;
                }
                return false;
            };

            function expand(a, recursive) {
                var s = a.nextSibling || {},
                    oldClass = s.className;
                if (/\bsf-dump-compact\b/.test(oldClass)) {
                    toggle(a, recursive);
                    return true;
                }
                return false;
            };

            function collapseAll(root) {
                var a = root.querySelector('a.sf-dump-toggle');
                if (a) {
                    collapse(a, true);
                    expand(a);
                    return true;
                }
                return false;
            }

            function reveal(node) {
                var previous, parents = [];
                while ((node = node.parentNode || {}) && (previous = node.previousSibling) && 'A' === previous.tagName) {
                    parents.push(previous);
                }
                if (0 !== parents.length) {
                    parents.forEach(function(parent) {
                        expand(parent);
                    });
                    return true;
                }
                return false;
            }

            function highlight(root, activeNode, nodes) {
                resetHighlightedNodes(root);
                Array.from(nodes || []).forEach(function(node) {
                    if (!/\bsf-dump-highlight\b/.test(node.className)) {
                        node.className = node.className + ' sf-dump-highlight';
                    }
                });
                if (!/\bsf-dump-highlight-active\b/.test(activeNode.className)) {
                    activeNode.className = activeNode.className + ' sf-dump-highlight-active';
                }
            }

            function resetHighlightedNodes(root) {
                Array.from(root.querySelectorAll('.sf-dump-str, .sf-dump-key, .sf-dump-public, .sf-dump-protected, .sf-dump-private')).forEach(function(strNode) {
                    strNode.className = strNode.className.replace(/\bsf-dump-highlight\b/, '');
                    strNode.className = strNode.className.replace(/\bsf-dump-highlight-active\b/, '');
                });
            }
            return function(root, x) {
                root = doc.getElementById(root);
                var indentRx = new RegExp('^(' + (root.getAttribute('data-indent-pad') || ' ').replace(rxEsc, '\\$1') + ')+', 'm'),
                    options = {
                        "maxDepth": 1,
                        "maxStringLength": 160,
                        "fileLinkFormat": false
                    },
                    elt = root.getElementsByTagName('A'),
                    len = elt.length,
                    i = 0,
                    s, h, t = [];
                while (i < len) t.push(elt[i++]);
                for (i in x) {
                    options[i] = x[i];
                }

                function a(e, f) {
                    addEventListener(root, e, function(e, n) {
                        if ('A' == e.target.tagName) {
                            f(e.target, e);
                        } else if ('A' == e.target.parentNode.tagName) {
                            f(e.target.parentNode, e);
                        } else {
                            n = /\bsf-dump-ellipsis\b/.test(e.target.className) ? e.target.parentNode : e.target;
                            if ((n = n.nextElementSibling) && 'A' == n.tagName) {
                                if (!/\bsf-dump-toggle\b/.test(n.className)) {
                                    n = n.nextElementSibling || n;
                                }
                                f(n, e, true);
                            }
                        }
                    });
                };

                function isCtrlKey(e) {
                    return e.ctrlKey || e.metaKey;
                }

                function xpathString(str) {
                    var parts = str.match(/[^'"]+|['"]/g).map(function(part) {
                        if ("'" == part) {
                            return '"\'"';
                        }
                        if ('"' == part) {
                            return "'\"'";
                        }
                        return "'" + part + "'";
                    });
                    return "concat(" + parts.join(",") + ", '')";
                }

                function xpathHasClass(className) {
                    return "contains(concat(' ', normalize-space(@class), ' '), ' " + className + " ')";
                }
                addEventListener(root, 'mouseover', function(e) {
                    if ('' != refStyle.innerHTML) {
                        refStyle.innerHTML = '';
                    }
                });
                a('mouseover', function(a, e, c) {
                    if (c) {
                        e.target.style.cursor = "pointer";
                    } else if (a = idRx.exec(a.className)) {
                        try {
                            refStyle.innerHTML = '.phpdebugbar pre.sf-dump .' + a[0] + '{background-color: #B729D9; color: #FFF !important; border-radius: 2px}';
                        } catch (e) {}
                    }
                });
                a('click', function(a, e, c) {
                    if (/\bsf-dump-toggle\b/.test(a.className)) {
                        e.preventDefault();
                        if (!toggle(a, isCtrlKey(e))) {
                            var r = doc.getElementById(a.getAttribute('href').slice(1)),
                                s = r.previousSibling,
                                f = r.parentNode,
                                t = a.parentNode;
                            t.replaceChild(r, a);
                            f.replaceChild(a, s);
                            t.insertBefore(s, r);
                            f = f.firstChild.nodeValue.match(indentRx);
                            t = t.firstChild.nodeValue.match(indentRx);
                            if (f && t && f[0] !== t[0]) {
                                r.innerHTML = r.innerHTML.replace(new RegExp('^' + f[0].replace(rxEsc, '\\$1'), 'mg'), t[0]);
                            }
                            if (/\bsf-dump-compact\b/.test(r.className)) {
                                toggle(s, isCtrlKey(e));
                            }
                        }
                        if (c) {} else if (doc.getSelection) {
                            try {
                                doc.getSelection().removeAllRanges();
                            } catch (e) {
                                doc.getSelection().empty();
                            }
                        } else {
                            doc.selection.empty();
                        }
                    } else if (/\bsf-dump-str-toggle\b/.test(a.className)) {
                        e.preventDefault();
                        e = a.parentNode.parentNode;
                        e.className = e.className.replace(/\bsf-dump-str-(expand|collapse)\b/, a.parentNode.className);
                    }
                });
                elt = root.getElementsByTagName('SAMP');
                len = elt.length;
                i = 0;
                while (i < len) t.push(elt[i++]);
                len = t.length;
                for (i = 0; i < len; ++i) {
                    elt = t[i];
                    if ('SAMP' == elt.tagName) {
                        a = elt.previousSibling || {};
                        if ('A' != a.tagName) {
                            a = doc.createElement('A');
                            a.className = 'sf-dump-ref';
                            elt.parentNode.insertBefore(a, elt);
                        } else {
                            a.innerHTML += ' ';
                        }
                        a.title = (a.title ? a.title + '\n[' : '[') + keyHint + '+click] Expand all children';
                        a.innerHTML += elt.className == 'sf-dump-compact' ? '<span>▶</span>' : '<span>▼</span>';
                        a.className += ' sf-dump-toggle';
                        x = 1;
                        if ('sf-dump' != elt.parentNode.className) {
                            x += elt.parentNode.getAttribute('data-depth') / 1;
                        }
                    } else if (/\bsf-dump-ref\b/.test(elt.className) && (a = elt.getAttribute('href'))) {
                        a = a.slice(1);
                        elt.className += ' ' + a;
                        if (/[\[{]$/.test(elt.previousSibling.nodeValue)) {
                            a = a != elt.nextSibling.id && doc.getElementById(a);
                            try {
                                s = a.nextSibling;
                                elt.appendChild(a);
                                s.parentNode.insertBefore(a, s);
                                if (/^[@#]/.test(elt.innerHTML)) {
                                    elt.innerHTML += ' <span>▶</span>';
                                } else {
                                    elt.innerHTML = '<span>▶</span>';
                                    elt.className = 'sf-dump-ref';
                                }
                                elt.className += ' sf-dump-toggle';
                            } catch (e) {
                                if ('&' == elt.innerHTML.charAt(0)) {
                                    elt.innerHTML = '…';
                                    elt.className = 'sf-dump-ref';
                                }
                            }
                        }
                    }
                }
                if (doc.evaluate && Array.from && root.children.length > 1) {
                    root.setAttribute('tabindex', 0);
                    SearchState = function() {
                        this.nodes = [];
                        this.idx = 0;
                    };
                    SearchState.prototype = {
                        next: function() {
                            if (this.isEmpty()) {
                                return this.current();
                            }
                            this.idx = this.idx < (this.nodes.length - 1) ? this.idx + 1 : 0;
                            return this.current();
                        },
                        previous: function() {
                            if (this.isEmpty()) {
                                return this.current();
                            }
                            this.idx = this.idx > 0 ? this.idx - 1 : (this.nodes.length - 1);
                            return this.current();
                        },
                        isEmpty: function() {
                            return 0 === this.count();
                        },
                        current: function() {
                            if (this.isEmpty()) {
                                return null;
                            }
                            return this.nodes[this.idx];
                        },
                        reset: function() {
                            this.nodes = [];
                            this.idx = 0;
                        },
                        count: function() {
                            return this.nodes.length;
                        },
                    };

                    function showCurrent(state) {
                        var currentNode = state.current(),
                            currentRect, searchRect;
                        if (currentNode) {
                            reveal(currentNode);
                            highlight(root, currentNode, state.nodes);
                            if ('scrollIntoView' in currentNode) {
                                currentNode.scrollIntoView(true);
                                currentRect = currentNode.getBoundingClientRect();
                                searchRect = search.getBoundingClientRect();
                                if (currentRect.top < (searchRect.top + searchRect.height)) {
                                    window.scrollBy(0, -(searchRect.top + searchRect.height + 5));
                                }
                            }
                        }
                        counter.textContent = (state.isEmpty() ? 0 : state.idx + 1) + ' of ' + state.count();
                    }
                    var search = doc.createElement('div');
                    search.className = 'sf-dump-search-wrapper sf-dump-search-hidden';
                    search.innerHTML = ' <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0<\/span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> ';
                    root.insertBefore(search, root.firstChild);
                    var state = new SearchState();
                    var searchInput = search.querySelector('.sf-dump-search-input');
                    var counter = search.querySelector('.sf-dump-search-count');
                    var searchInputTimer = 0;
                    var previousSearchQuery = '';
                    addEventListener(searchInput, 'keyup', function(e) {
                        var searchQuery = e.target.value; /* Don't perform anything if the pressed key didn't change the query */
                        if (searchQuery === previousSearchQuery) {
                            return;
                        }
                        previousSearchQuery = searchQuery;
                        clearTimeout(searchInputTimer);
                        searchInputTimer = setTimeout(function() {
                            state.reset();
                            collapseAll(root);
                            resetHighlightedNodes(root);
                            if ('' === searchQuery) {
                                counter.textContent = '0 of 0';
                                return;
                            }
                            var classMatches = ["sf-dump-str", "sf-dump-key", "sf-dump-public", "sf-dump-protected", "sf-dump-private", ].map(xpathHasClass).join(' or ');
                            var xpathResult = doc.evaluate('.//span[' + classMatches + '][contains(translate(child::text(), ' + xpathString(searchQuery.toUpperCase()) + ', ' + xpathString(searchQuery.toLowerCase()) + '), ' + xpathString(searchQuery.toLowerCase()) + ')]', root, null, XPathResult.ORDERED_NODE_ITERATOR_TYPE, null);
                            while (node = xpathResult.iterateNext()) state.nodes.push(node);
                            showCurrent(state);
                        }, 400);
                    });
                    Array.from(search.querySelectorAll('.sf-dump-search-input-next, .sf-dump-search-input-previous')).forEach(function(btn) {
                        addEventListener(btn, 'click', function(e) {
                            e.preventDefault(); - 1 !== e.target.className.indexOf('next') ? state.next() : state.previous();
                            searchInput.focus();
                            collapseAll(root);
                            showCurrent(state);
                        })
                    });
                    addEventListener(root, 'keydown', function(e) {
                        var isSearchActive = !/\bsf-dump-search-hidden\b/.test(search.className);
                        if ((114 === e.keyCode && !isSearchActive) || (isCtrlKey(e) && 70 === e.keyCode)) {
                            /* F3 or CMD/CTRL + F */
                            if (70 === e.keyCode && document.activeElement === searchInput) {
                                /* * If CMD/CTRL + F is hit while having focus on search input, * the user probably meant to trigger browser search instead. * Let the browser execute its behavior: */
                                return;
                            }
                            e.preventDefault();
                            search.className = search.className.replace(/\bsf-dump-search-hidden\b/, '');
                            searchInput.focus();
                        } else if (isSearchActive) {
                            if (27 === e.keyCode) {
                                /* ESC key */
                                search.className += ' sf-dump-search-hidden';
                                e.preventDefault();
                                resetHighlightedNodes(root);
                                searchInput.value = '';
                            } else if ((isCtrlKey(e) && 71 === e.keyCode) /* CMD/CTRL + G */ || 13 === e.keyCode /* Enter */ || 114 === e.keyCode /* F3 */ ) {
                                e.preventDefault();
                                e.shiftKey ? state.previous() : state.next();
                                collapseAll(root);
                                showCurrent(state);
                            }
                        }
                    });
                }
                if (0 >= options.maxStringLength) {
                    return;
                }
                try {
                    elt = root.querySelectorAll('.sf-dump-str');
                    len = elt.length;
                    i = 0;
                    t = [];
                    while (i < len) t.push(elt[i++]);
                    len = t.length;
                    for (i = 0; i < len; ++i) {
                        elt = t[i];
                        s = elt.innerText || elt.textContent;
                        x = s.length - options.maxStringLength;
                        if (0 < x) {
                            h = elt.innerHTML;
                            elt[elt.innerText ? 'innerText' : 'textContent'] = s.substring(0, options.maxStringLength);
                            elt.className += ' sf-dump-str-collapse';
                            elt.innerHTML = '<span class=sf-dump-str-collapse>' + h + '<a class="sf-dump-ref sf-dump-str-toggle" title="Collapse"> ◀</a></span>' + '<span class=sf-dump-str-expand>' + elt.innerHTML + '<a class="sf-dump-ref sf-dump-str-toggle" title="' + x + ' remaining characters"> ▶</a></span>';
                        }
                    }
                } catch (e) {}
            };
        })(document);
    </script>
</head>

<body class="layout-fixed layout-navbar-fixed sidebar-mini-1 sidebar-collapse" data-scrollbar-auto-hide=1>


    <div class="wrapper">


        <div class="preloader flex-column justify-content-center align-items-center">


            <img src="http://127.0.0.1:8000/vendor/adminlte/dist/img/AdminLTELogo.png" class="animation__shake" alt="AdminLTE Preloader Image" width="60" height="60">

        </div>


        <nav class="main-header navbar
    navbar-expand
    navbar-white navbar-light">


            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                        <span class="sr-only">Alternar barra de navegación</span>
                    </a>
                </li>



            </ul>


            <ul class="navbar-nav ml-auto">





                <li class="nav-item dropdown user-menu">


                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span>
                            Francisco Gonzalez
                        </span>
                    </a>


                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                        <li class="user-footer">
                            <a class="btn btn-default btn-flat float-right  btn-block " href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off text-red"></i>
                                Salir
                            </a>
                            <form id="logout-form" action="http://127.0.0.1:8000/logout" method="POST" style="display: none;">
                                <input type="hidden" name="_token" value="uEtQM11nFX9A8A7V4SUaWkTgw0W5cPYYOmljmZa1">
                            </form>
                        </li>

                    </ul>

                </li>


            </ul>

        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4 my-4">


            <a href="http://127.0.0.1:8000/home" class="brand-link bg-black border-white border-4">


                <img src="http://127.0.0.1:8000/vendor/adminlte/dist/img/cafeto_logo_min.png" alt="CAFETO" class="brand-image img-circle elevation-3" style="opacity:.8">


                <span class="brand-text font-weight-light ">
                    <b>Avan</b>Ciencia
                </span>

            </a>


            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu">

                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/submodulos/21">
                                <i class="fa fa-poll-h nav-icon"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/clientes/list">
                                <i class="fa fa-university nav-icon"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/cuestionarios/list">
                                <i class="fa fa-list-alt  nav-icon"></i>
                                <p>Formularios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/procesos/list">
                                <i class="fa fa-project-diagram nav-icon"></i>
                                <p>Procesos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/proyectos/list">
                                <i class="fa fa-tasks nav-icon"></i>
                                <p>Documentos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/modulos/11?model=evaluadores">
                                <i class="fa fa-user-circle nav-icon"></i>
                                <p>Evaluadores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/reviewer/projects?model=evaluaciones">
                                <i class="fa fa-poll-h nav-icon"></i>
                                <p>Evaluaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/tarifas/list">
                                <i class="fa fa-file-invoice-dollar nav-icon"></i>
                                <p>Tarifas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/review/list?model=evaluaciones">
                                <i class="fa fa-poll-h nav-icon"></i>
                                <p>Evaluaciones (Gestor)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/formatos/list">
                                <i class="fa fa-list  nav-icon"></i>
                                <p>Formatos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/notificaciones/list">
                                <i class="fa fa-envelope nav-icon"></i>
                                <p>Notificaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/customer/dashboard">
                                <i class="fa fa-chart-pie nav-icon"></i>
                                <p>Panel Cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/committee/review/list?model=evaluaciones">
                                <i class="fa fa-check-square nav-icon"></i>
                                <p>Comité Académico</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/user/profile/show?model=evaluaciones">
                                <i class="fa fa-id-badge nav-icon"></i>
                                <p>Perfil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://127.0.0.1:8000/crud/modulos/list">
                                <i class="fa fa-magic  nav-icon"></i>
                                <p>Módulos</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </aside>


        <div class="content-wrapper ">




            <div class="content">
                <div class="container-fluid">
                    <main>
                        <div class="row">
                            <div class="col-lg-10 col-10 offset-md-1">
                                <div class="bs-stepper">
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="step " data-target="#Crear"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="http://127.0.0.1:8000/formulario/new/136" id="Crearlogins-part-trigger"><span class="bs-stepper-circle">&lt;</span><span class="bs-stepper-label">Crear</span></a></div>
                                        <div class="line"></div>


                                        <div class="step active" data-target="#Módulo I"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="/formreview/neweditor/136/1" id="Módulo Ilogins-part-trigger"><span class="bs-stepper-circle">1</span><span class="bs-stepper-label"></span></a></div>
                                        <div class="line"></div>

                                        <div class="step " data-target="#Publicar"><a type="button" class="step-trigger" role="tab" aria-controls="logins-part" href="http://127.0.0.1:8000/formreview/publish/136" id="Publicarlogins-part-trigger"><span class="bs-stepper-circle">&gt;</span><span class="bs-stepper-label">Publicar</span></a></div>
                                    </div>
                                </div>
                                <div class="card card-outline card-info undefined">
                                    <div class="card-header">
                                        <h3 class="card-title"> Nuevo Módulo Preguntas </h3>
                                        <div class="card-tools">
                                            <div class="btn-group"></div>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button><button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                        </div>

                                    </div>
                                    <div class="card-body">

                                        <div class="form-group undefined">
                                            <div><label for="pageName">Nombre del Módulo</label>*<a href="#" id="ttip_pageName" title="Nombre del Módulo" class="fa fa-question-circle" data-toggle="tooltip"></a></div>

                                            <input name="pageName" type="text" class="form-control input-sm" id="pageName" placeholder="Nombre del Módulo" value="">
                                        </div>


                                        <div id="fb-editor"></div>

                                        <form method="POST" autocomplete="off" id="formGuardaModulo" action="http://127.0.0.1:8000/formreview/guardaModulo">
                                            <input type="hidden" name="_token" value="uEtQM11nFX9A8A7V4SUaWkTgw0W5cPYYOmljmZa1">
                                            <div class="form-group undefined">
                                                <div><label for="pageName">Estado</label>*<a href="#" id="ttip_pageName" title="Estado" class="fa fa-question-circle" data-toggle="tooltip"></a>

                                                </div>
                                                <select required name="state" class="form-control input-sm">

                                                    <option value="active">Activo</option>
                                                    <option value="inactive">Inactivo</option>
                                                </select>

                                            </div>


                                            <input type="hidden" name="module_name" id="module_name">
                                            <input type="hidden" name="form_id" value="136">
                                            <input type="hidden" name="module_id" value="1">
                                            <input type="hidden" name="json" id="json">
                                    </div>
                                    <div class="card-footer">
                                        <input type="submit" value="Guardar" class="btn btn-warning" id="guardaModulo">
                                        <a href="1" value="Guardar" class="btn btn-info">Nuevo Módulo</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>



                </div>
            </div>

        </div>





    </div>


    <script src="http://127.0.0.1:8000/vendor/jquery/jquery.min.js"></script>
    <script src="http://127.0.0.1:8000/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="http://127.0.0.1:8000/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="http://127.0.0.1:8000/vendor/adminlte/dist/js/adminlte.min.js"></script>


    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="/js/ckeditor/ckeditor.js"></script>



    <script src="/js/form-builder-new/form-builder.min.js"></script>

    <script>
        jQuery(function($) {
            var fbTemplate = document.getElementById('fb-editor'),
                options = {
                    typeUserAttrs: {

                        textarea: {
                            minlength: {
                                label: 'Longitud Mínima',
                                value: 50,
                                type: 'number'
                            },
                        },

                        number: {
                            min: {
                                label: 'Min',
                                value: 1,
                            },
                            max: {
                                label: 'Max',
                                value: 10,
                            },

                            ponderacion: {
                                label: 'ponderación',
                                value: '1',
                            },
                            //  label: 'Número'
                        },
                        text: {
                            minlength: {
                                label: 'Longitud Mínima',
                                value: 0,
                                type: 'number'
                            }
                        },



                    },
                    disabledAttrs: ["class", "name", "access"],
                    controlOrder: [
                        'header',
                        'paragraph',
                        'text',
                        'textarea',
                        'number',
                        'select',
                        'autocomplete',
                    ],
                    i18n: {
                        locale: 'es-ES',
                        location: '/js/form-builder-new/'
                    },
                    disableFields: ['button', 'file', 'hidden', 'data'],
                    formData: '{!!  $encodedQuestions !!}',

                };
            var form = $(fbTemplate).formBuilder(options);

            console.log('');


            $('#guardaModulo').click(function(e) {
                e.preventDefault();
                $('#json').val(form.actions.getData('json'));

                $('#module_name').val($('#pageName').val());

                $('#formGuardaModulo').submit();

            });


        


        });
    </script>

</body>

</html>