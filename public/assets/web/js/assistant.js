/*
 * AI Help Center - browser behaviour.
 *
 * Drives two surfaces from one code path: the hero ask bar (answers appear
 * inline, no page change) and the floating widget (a running thread on every
 * page). Both post to the same endpoint, so an answer never differs by where it
 * was asked.
 *
 * Progressive enhancement: the hero markup is a real GET form to /ask and the
 * launcher is hidden until this file runs, so with JavaScript off the visitor
 * still gets the server-rendered answer page instead of a dead button.
 *
 * jQuery only - it is already loaded site-wide. Alpine is not loaded on the
 * public site, and the Tailwind bundle is pre-built, which is why every class
 * here comes from assistant.css rather than utility classes.
 */
(function ($) {
    'use strict';

    var cfg = window.amlkAssistant;

    if (!cfg || !cfg.askUrl) {
        return;
    }

    var t = cfg.strings || {};
    var MAX_LEN = 500;

    /* ------------------------------------------------------------- helpers */

    function el(tag, className, text) {
        var node = document.createElement(tag);
        if (className) {
            node.className = className;
        }
        if (text !== undefined && text !== null) {
            node.textContent = text;
        }
        return node;
    }

    /*
     * Marks a node as belonging to the answer's language.
     *
     * The answer is not always in the page's language: the server follows the
     * question's own script, so an Arabic question asked on the English site
     * comes back in Arabic. Without dir="rtl" on the node that Arabic renders
     * left-to-right with its punctuation stranded on the wrong end.
     */
    function applyDir(node, lang) {
        if (lang !== 'ar' && lang !== 'en') {
            return node;
        }
        node.setAttribute('lang', lang);
        node.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
        return node;
    }

    // Answers are plain text from the model. Building the DOM node by node keeps
    // it that way - nothing the model writes can become markup.
    function paragraph(text, lang) {
        var p = applyDir(el('p', 'amlk-answer__body'), lang);
        String(text).split(/\n+/).forEach(function (line, i) {
            if (i > 0) {
                p.appendChild(document.createElement('br'));
            }
            p.appendChild(document.createTextNode(line));
        });
        return p;
    }

    function typing() {
        var wrap = el('div', 'amlk-typing');
        wrap.setAttribute('aria-label', t.thinking || 'Thinking');
        for (var i = 0; i < 3; i++) {
            wrap.appendChild(el('span'));
        }
        return wrap;
    }

    /*
     * The widget's thread handle.
     *
     * Held in localStorage so a conversation survives a page change, which is
     * the whole point - the widget is on every page and the visitor keeps
     * browsing while it is open. Every access is guarded: private windows and
     * browsers set to block site data throw on the property itself, and a
     * visitor who cannot store a handle should simply get single-shot answers,
     * not a broken widget.
     */
    var thread = {
        key: cfg.threadKey || 'amlk-thread',

        get: function () {
            try {
                return window.localStorage.getItem(this.key) || null;
            } catch (e) {
                return null;
            }
        },

        set: function (uuid) {
            if (!uuid) {
                return;
            }
            try {
                window.localStorage.setItem(this.key, uuid);
            } catch (e) {
                /* Answers still work; only the memory between them is lost. */
            }
        }
    };

    /*
     * `threaded` is true only for the floating widget. The hero ask bar sends
     * no thread, so its answer stays a standalone, cacheable, shareable one.
     */
    function ask(question, threaded) {
        var payload = { _token: cfg.csrf, question: question };

        if (threaded) {
            payload.thread = 1;

            var uuid = thread.get();

            if (uuid) {
                payload.conversation = uuid;
            }
        }

        return $.ajax({
            url: cfg.askUrl,
            method: 'POST',
            dataType: 'json',
            data: payload
        });
    }

    function errorMessage(xhr) {
        if (xhr && xhr.status === 429) {
            return t.rateLimited || 'Too many questions just now. Please wait a moment and try again.';
        }
        if (xhr && (xhr.status === 419 || xhr.status === 401)) {
            return t.expired || 'Your session expired. Please refresh the page and try again.';
        }
        return t.failed || 'Something went wrong. Please try again.';
    }

    /* ------------------------------------------------------- answer rendering */

    function sourcesBlock(sources, lang) {
        // Source titles come from the index in the answer's language too.
        var wrap = applyDir(el('div', 'amlk-sources'), lang);
        wrap.appendChild(el('p', 'amlk-sources__label', t.sources || 'Sources on this site'));

        var list = el('ul', 'amlk-sources__list');

        sources.forEach(function (source) {
            var li = document.createElement('li');
            var a = el('a', null, source.title || '');
            a.href = source.url || '#';
            if (source.url) {
                a.target = '_blank';
                a.rel = 'noopener';
            }
            li.appendChild(a);

            /* One line on why this link is worth opening. Model text, so it goes
               in as a text node - el() uses textContent, never innerHTML. */
            if (source.reason) {
                li.appendChild(el('span', 'amlk-sources__why', source.reason));
            }

            list.appendChild(li);
        });

        wrap.appendChild(list);
        return wrap;
    }

    /*
     * Follow-up chips.
     *
     * Only rendered where there is somewhere for the answer to go - the widget
     * passes an `onPick` handler, the hero bar does not, and without one the
     * chips are left out rather than rendered as dead buttons.
     */
    function repliesBlock(replies, lang, onPick) {
        var wrap = applyDir(el('div', 'amlk-replies'), lang);

        replies.forEach(function (reply) {
            var chip = el('button', 'amlk-replies__chip', reply);
            chip.type = 'button';
            chip.addEventListener('click', function () {
                onPick(reply);
            });
            wrap.appendChild(chip);
        });

        return wrap;
    }

    function feedbackBlock(queryId) {
        var wrap = el('div', 'amlk-feedback');
        wrap.appendChild(el('span', null, t.helpful || 'Was this helpful?'));

        var thanks = el('span', 'amlk-feedback__thanks', t.thanks || 'Thanks for the feedback.');
        thanks.hidden = true;

        [['1', t.yes || 'Yes'], ['0', t.no || 'No']].forEach(function (pair) {
            var btn = el('button', 'amlk-feedback__btn', pair[1]);
            btn.type = 'button';

            $(btn).on('click', function () {
                $(wrap).find('.amlk-feedback__btn').prop('disabled', true);
                thanks.hidden = false;

                // Fire and forget - a failed write is not the visitor's problem.
                $.ajax({
                    url: cfg.feedbackUrl,
                    method: 'POST',
                    data: { _token: cfg.csrf, query_id: queryId, helpful: pair[0] }
                });
            });

            wrap.appendChild(btn);
        });

        wrap.appendChild(thanks);
        return wrap;
    }

    /**
     * Renders one answer into a fragment shared by both surfaces.
     *
     * `compact` drops the echoed question, which the widget already shows as the
     * visitor's own bubble directly above.
     */
    function answerNodes(data, question, compact, onPick) {
        var frag = document.createDocumentFragment();

        if (!compact && question) {
            frag.appendChild(el('p', 'amlk-answer__q', question));
        }

        if (data.status === 'ok' && data.answer) {
            frag.appendChild(paragraph(data.answer, data.lang));

            if (data.route_url) {
                var cta = el('div', 'amlk-answer__cta');
                var link = el('a', 'amlk-btn', t.startRequest || 'Start a request');
                link.href = data.route_url;
                cta.appendChild(link);
                frag.appendChild(cta);
            }

            if (data.sources && data.sources.length) {
                frag.appendChild(sourcesBlock(data.sources, data.lang));
            }
        } else {
            frag.appendChild(paragraph(data.message || t.noAnswer || '', data.lang));

            var fallback = el('div', 'amlk-answer__cta');

            if (cfg.contactUrl) {
                var contact = el('a', 'amlk-btn', t.contact || 'Contact us');
                contact.href = cfg.contactUrl;
                fallback.appendChild(contact);
            }

            if (cfg.servicesUrl) {
                var browse = el('a', 'amlk-btn amlk-btn--ghost', t.browse || 'Browse all services');
                browse.href = cfg.servicesUrl;
                fallback.appendChild(browse);
            }

            frag.appendChild(fallback);
        }

        if (data.query_id) {
            frag.appendChild(feedbackBlock(data.query_id));
        }

        if (onPick && data.suggested_replies && data.suggested_replies.length) {
            frag.appendChild(repliesBlock(data.suggested_replies, data.lang, onPick));
        }

        return frag;
    }

    /* ----------------------------------------------------------- hero ask bar */

    $('[data-amlk-form]').each(function () {
        var $form = $(this);
        var $input = $form.find('[data-amlk-input]');
        var $button = $form.find('[data-amlk-submit]');
        var $target = $($form.attr('data-amlk-form'));

        if (!$target.length) {
            return;
        }

        function run(question) {
            question = $.trim(question).slice(0, MAX_LEN);

            if (!question) {
                $input.trigger('focus');
                return;
            }

            var card = el('div', 'amlk-answer');
            card.appendChild(el('p', 'amlk-answer__q', question));
            card.appendChild(typing());

            $target.empty().append(card).attr('aria-busy', 'true');
            $button.prop('disabled', true);

            ask(question)
                .done(function (data) {
                    var fresh = el('div', 'amlk-answer' + (data.status === 'ok' ? '' : ' amlk-answer--empty'));
                    fresh.appendChild(answerNodes(data, question, false));
                    $target.empty().append(fresh);
                })
                .fail(function (xhr) {
                    var box = el('div', 'amlk-answer amlk-answer--empty');
                    box.appendChild(el('p', 'amlk-answer__q', question));
                    box.appendChild(el('div', 'amlk-error', errorMessage(xhr)));
                    $target.empty().append(box);
                })
                .always(function () {
                    $target.attr('aria-busy', 'false');
                    $button.prop('disabled', false);
                });
        }

        $form.on('submit', function (event) {
            event.preventDefault();
            run($input.val());
        });

        // Suggestion chips answer in place instead of navigating away.
        $form.closest('[data-amlk-scope]').on('click', '[data-amlk-suggest]', function (event) {
            event.preventDefault();
            var question = $(this).attr('data-amlk-suggest');
            $input.val(question);
            run(question);
        });
    });

    /* -------------------------------------------------------------- widget */

    (function widget() {
        var $launcher = $('[data-amlk-open]');
        var $panel = $('[data-amlk-panel]');

        if (!$launcher.length || !$panel.length) {
            return;
        }

        var $thread = $panel.find('[data-amlk-thread]');
        var $form = $panel.find('[data-amlk-widget-form]');
        var $input = $panel.find('[data-amlk-widget-input]');
        var $button = $panel.find('[data-amlk-widget-submit]');
        var STORAGE_KEY = 'amlk.panel.open';

        /*
         * Keep the launcher clear of the WhatsApp button.
         *
         * Both are pinned to the bottom-right, so without this they overlap.
         * The CSS already offsets the launcher by the height that widget has
         * today; this measures the real button and corrects the offset, so the
         * two stay stacked if WATI ever renders a taller pill or the Arabic CTA
         * wraps to two lines.
         *
         * Entirely optional: the widget is a third-party script that may be
         * disabled or blocked, and when it is absent the CSS value stands.
         */
        function stackAboveWhatsApp() {
            var wa = document.querySelector(
                '.wa-widget-send-button, #wa-widget-send-button, [class*="wa-widget-send"]'
            );

            if (!wa) {
                return;
            }

            var rect = wa.getBoundingClientRect();

            if (!rect.height) {
                return;
            }

            /*
             * Match BOTH edges, not just the vertical one.
             *
             * Matching only `bottom` left the two pills staggered: this launcher
             * sat at the CSS right offset while WATI sat at its own (50px, and a
             * different value again on a phone), so they lined up on no edge at
             * all and read as two loose buttons rather than one stack.
             */
            var gap = window.innerWidth < 560 ? 12 : 16;
            var clearance = Math.round(window.innerHeight - rect.top + gap);
            var rightEdge = Math.round(window.innerWidth - rect.right);

            if (clearance > 0 && clearance < window.innerHeight / 2) {
                $launcher.css('bottom', clearance + 'px');
            }

            if (rightEdge >= 0 && rightEdge < window.innerWidth / 2) {
                $launcher.css('right', rightEdge + 'px');
            }
        }

        /* The WhatsApp script is injected async and mounts some time after we
           do, so this is retried rather than measured once. */
        stackAboveWhatsApp();
        setTimeout(stackAboveWhatsApp, 1200);
        setTimeout(stackAboveWhatsApp, 3500);
        $(window).on('resize', stackAboveWhatsApp);

        // The launcher stays hidden in the markup so it never appears for a
        // visitor whose browser would leave it inert.
        $launcher.prop('hidden', false);

        function scrollDown() {
            $thread.stop().animate({ scrollTop: $thread[0].scrollHeight }, 200);
        }

        function open() {
            $panel.prop('hidden', false);
            $launcher.prop('hidden', true);
            $input.trigger('focus');
            scrollDown();
            try {
                sessionStorage.setItem(STORAGE_KEY, '1');
            } catch (e) {
                /* private mode - the panel just will not persist */
            }
        }

        function close() {
            $panel.prop('hidden', true);
            $launcher.prop('hidden', false).trigger('focus');
            try {
                sessionStorage.removeItem(STORAGE_KEY);
            } catch (e) {}
        }

        function run(question) {
            question = $.trim(question).slice(0, MAX_LEN);

            if (!question) {
                return;
            }

            $panel.find('[data-amlk-intro]').remove();
            $thread.append(el('div', 'amlk-msg amlk-msg--me', question));

            var pending = el('div', 'amlk-msg amlk-msg--bot');
            pending.appendChild(typing());
            $thread.append(pending);

            $input.val('');
            $button.prop('disabled', true);
            scrollDown();

            /* The widget is the threaded surface - true here, nowhere else. */
            ask(question, true)
                .done(function (data) {
                    thread.set(data.conversation);
                    pending.innerHTML = '';
                    // `run` as the pick handler: a chip asks its question on
                    // this same thread rather than navigating anywhere.
                    pending.appendChild(answerNodes(data, question, true, run));
                })
                .fail(function (xhr) {
                    pending.innerHTML = '';
                    pending.appendChild(el('div', 'amlk-error', errorMessage(xhr)));
                })
                .always(function () {
                    $button.prop('disabled', false);
                    scrollDown();
                    $input.trigger('focus');
                });
        }

        $launcher.on('click', open);
        $panel.on('click', '[data-amlk-close]', close);

        $form.on('submit', function (event) {
            event.preventDefault();
            run($input.val());
        });

        $panel.on('click', '[data-amlk-suggest]', function () {
            run($(this).attr('data-amlk-suggest'));
        });

        $(document).on('keydown', function (event) {
            if (event.key === 'Escape' && !$panel.prop('hidden')) {
                close();
            }
        });

        try {
            if (sessionStorage.getItem(STORAGE_KEY) === '1') {
                open();
            }
        } catch (e) {}
    })();
})(jQuery);
