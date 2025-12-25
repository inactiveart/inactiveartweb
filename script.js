/**
 * @architect    Inactiveart (System Architect & UI Engineer)
 * @project      Inactiveart Official Portfolio (V1.0)
 * @copyright    2025 Inactiveart. All rights reserved.
 * @description  Main portfolio interface and digital architecture showcase.
 */

console.log(
    "%c INACTIVEART %c SYSTEM READY ",
    "background:#000; color:#fff; padding:5px; font-family:'Fira Code'; font-weight:bold; border-radius:3px 0 0 3px;",
    "background:#3b82f6; color:#000; padding:5px; font-family:'Fira Code'; font-weight:bold; border-radius:0 3px 3px 0;"
);
console.log("Architected & Developed by Inactiveart.");
console.log("---------------------------------------");

const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smooth: true,
    direction: 'vertical',
    gestureDirection: 'vertical',
    mouseMultiplier: 1,
    smoothTouch: false,
    touchMultiplier: 2,
});

lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {

    const cursorDot = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');

    if (cursorDot && cursorOutline && window.matchMedia("(pointer: fine)").matches) {
        window.addEventListener('mousemove', (e) => {
            const posX = e.clientX;
            const posY = e.clientY;

            cursorDot.style.left = `${posX}px`;
            cursorDot.style.top = `${posY}px`;

            cursorOutline.animate({
                left: `${posX}px`,
                top: `${posY}px`
            }, { duration: 500, fill: "forwards" });
        });

        const hoverTargets = document.querySelectorAll('a, button, .work-item, .cat-titles, .hero-title');

        const addHover = () => document.body.classList.add('hovering');
        const removeHover = () => document.body.classList.remove('hovering');

        hoverTargets.forEach(el => {
            el.addEventListener('mouseenter', addHover);
            el.addEventListener('mouseleave', removeHover);
        });

        window.addEventListener('mousedown', () => {
            cursorOutline.style.transform = 'translate(-50%, -50%) scale(0.7)';
        });
        window.addEventListener('mouseup', () => {
            cursorOutline.style.transform = 'translate(-50%, -50%) scale(1)';
        });
    }

    fetch('data.json')
        .then(response => response.json())
        .then(data => {
            const socialContainer = document.getElementById('dynamic-socials');
            if (socialContainer && data.social) {
                let html = '';

                if (data.social.x) {
                    html += `<a href="${data.social.x}" target="_blank" class="icon-link x-icon" aria-label="X (Twitter) profilimiz">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>`;
                }
                if (data.social.instagram) {
                    html += `<a href="${data.social.instagram}" target="_blank" class="icon-link ig-icon" aria-label="Instagram profilimiz">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>`;
                }
                if (data.social.github) {
                    html += `<a href="${data.social.github}" target="_blank" class="icon-link git-icon" aria-label="GitHub profilimiz">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>`;
                }

                socialContainer.innerHTML = html;
            }

            const worksSection = document.getElementById('works');
            if (worksSection && data.portfolio) {
                const container = worksSection.querySelector('.container');
                if (container) {
                    const sectionHeader = container.querySelector('.section-header');
                    container.innerHTML = '';
                    if (sectionHeader) container.appendChild(sectionHeader);

                    Object.keys(data.portfolio).forEach(catKey => {
                        const category = data.portfolio[catKey];

                        const categoryDiv = document.createElement('div');
                        categoryDiv.className = 'category-row reveal-stagger';

                        categoryDiv.innerHTML = `
                            <div class="category-header">
                                <div class="cat-titles">
                                    <h3>
                                        ${category.title_en}
                                        <span class="tr-title">/ ${category.title_tr}</span>
                                    </h3>
                                </div>
                                <div class="cat-desc">${category.desc}</div>
                            </div>
                            <div class="portfolio-reel">
                                ${category.items ? category.items.map(item => `
                                    <article class="work-item">
                                        <figure>
                                            <img src="${item.img}" alt="${item.title}" loading="lazy" decoding="async">
                                        </figure>
                                        <h4 class="work-title">${item.title}</h4>
                                    </article>
                                `).join('') : ''}
                            </div>
                        `;

                        container.appendChild(categoryDiv);
                    });

                    const newRevealElements = container.querySelectorAll('.reveal-stagger');
                    newRevealElements.forEach(el => {
                        gsap.fromTo(el,
                            { y: 50, opacity: 0 },
                            {
                                y: 0,
                                opacity: 1,
                                duration: 1.2,
                                ease: "power3.out",
                                scrollTrigger: {
                                    trigger: el,
                                    start: "top bottom-=100",
                                    toggleActions: "play none none reverse"
                                }
                            }
                        );
                    });

                    const newWorkItems = container.querySelectorAll('.work-item');
                    newWorkItems.forEach(item => {
                        gsap.fromTo(item,
                            { y: 100, opacity: 0 },
                            {
                                y: 0,
                                opacity: 1,
                                duration: 1.5,
                                ease: "power3.out",
                                scrollTrigger: {
                                    trigger: item,
                                    start: "top bottom-=50",
                                    toggleActions: "play none none reverse"
                                }
                            }
                        );
                    });
                }
            }

            const philosophyText = document.querySelector('#about .reveal-text p');
            if (philosophyText && data.philosophy && data.philosophy.content) {
                philosophyText.textContent = data.philosophy.content;
            }
        })
        .catch(err => console.error("Data load error:", err));

    const logMessage = document.getElementById('log-message');
    const preloader = document.getElementById('preloader');
    const customCursor = document.querySelector('.terminal-content .cursor');

    const ambient = document.getElementById('ambientDrone');
    const clickSound = document.getElementById('uiClick');

    const messages = [
        "INITIALIZING...",
        "DECRYPTING...",
        "ACCESS GRANTED."
    ];

    const typingDelay = 20;

    function typeMessage(text, callback) {
        if (!logMessage) { if (callback) callback(); return; }

        let i = 0;
        logMessage.textContent = '';

        function typing() {
            if (i < text.length) {
                logMessage.textContent += text.charAt(i);
                i++;
                setTimeout(typing, typingDelay);
            } else if (callback) {
                setTimeout(callback, 200);
            }
        }
        typing();
    }

    function startLogSequence(index = 0) {
        if (index < messages.length) {
            typeMessage(messages[index], () => {
                startLogSequence(index + 1);
            });
        } else {
            setTimeout(destroyPreloader, 500);
        }
    }

    function destroyPreloader() {
        if (customCursor) customCursor.style.display = 'none';
        if (preloader) {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
                initHeroAnimation();
            }, 500);
        }
        sessionStorage.setItem('siteLoaded', 'true');
    }

    function initializeAmbientAudio() {
        if (ambient && ambient.paused) {
            ambient.volume = 0.15;
            ambient.play().catch(e => {
                console.warn('Ambient audio blocked by browser. User interaction needed.');
            });
        }
    }

    function setupHoverSounds() {
        const toggleBtn = document.getElementById('soundToggle');
        const soundStatus = document.getElementById('soundStatus');
        let isSoundOn = false;

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                isSoundOn = !isSoundOn;
                if (soundStatus) {
                    soundStatus.innerText = isSoundOn ? "ON" : "OFF";
                    soundStatus.style.color = isSoundOn ? "#10b981" : "#3b82f6";
                }
            });
        }

        const interactiveElements = document.querySelectorAll('nav a, .work-item, .cmd-btn, .cat-item, .hero-title');

        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => {
                if (clickSound && isSoundOn) {
                    const soundClone = clickSound.cloneNode();
                    soundClone.volume = 0.3;
                    soundClone.play().catch(e => console.warn('UI sound playback failed.'));
                }
            });
        });
    }

    setTimeout(() => {
        if (document.getElementById('preloader')) {
            document.getElementById('preloader').style.display = 'none';
        }
    }, 4000);

    const isLoaded = sessionStorage.getItem('siteLoaded');

    if (isLoaded === 'true') {
        if (preloader) {
            preloader.style.opacity = '0';
            preloader.style.display = 'none';
            initHeroAnimation();
        }
    } else {
        if (preloader) preloader.style.display = 'flex';
        startLogSequence();
    }

    setupHoverSounds();

    if (ambient) {
        document.addEventListener('click', initializeAmbientAudio, { once: true });
        initializeAmbientAudio();
    }

    gsap.to(".site-header.reveal", {
        opacity: 1,
        y: 0,
        duration: 1.5,
        ease: "power3.out",
        delay: 0.2
    });

    const heroText = document.querySelector(".hero-text");
    if (heroText) {
        gsap.fromTo(heroText,
            { y: 100, opacity: 0 },
            { y: 0, opacity: 1, duration: 1.5, ease: "power4.out", delay: 0.5 }
        );
    }

    const revealElements = document.querySelectorAll(".reveal-stagger");
    revealElements.forEach(el => {
        gsap.fromTo(el,
            { y: 50, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 1.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top bottom-=100",
                    toggleActions: "play none none reverse"
                }
            }
        );
    });

    const workItems = document.querySelectorAll(".work-item");
    workItems.forEach(item => {
        gsap.fromTo(item,
            { y: 100, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 1.5,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: item,
                    start: "top bottom-=50",
                    toggleActions: "play none none reverse"
                }
            }
        );
    });

    const footerReveals = document.querySelectorAll(".site-footer .reveal");
    if (footerReveals.length > 0) {
        gsap.fromTo(".site-footer .reveal",
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: 1,
                stagger: 0.2,
                scrollTrigger: {
                    trigger: ".site-footer",
                    start: "top bottom-=20",
                    toggleActions: "play none none reverse"
                }
            }
        );
    }

    class HackerEffect {
        constructor(element) {
            this.element = element;
            this.originalText = element.dataset.value || element.innerText;
            this.chars = "XY01";
            this.interval = null;
            this.isAnimating = false;
        }

        run() {
            if (this.isAnimating) return;
            this.isAnimating = true;

            let iterations = 0;
            const targetText = this.originalText;
            const element = this.element;
            const chars = this.chars;

            clearInterval(this.interval);

            this.interval = setInterval(() => {
                element.innerText = targetText
                    .split("")
                    .map((letter, index) => {
                        if (index < iterations) {
                            return targetText[index];
                        }
                        return chars[Math.floor(Math.random() * chars.length)];
                    })
                    .join("");

                if (iterations >= targetText.length) {
                    clearInterval(this.interval);
                    this.isAnimating = false;
                    element.innerText = targetText;
                }

                iterations += 1 / 2;
            }, 30);
        }
    }

    function initHeroAnimation() {
        const titles = document.querySelectorAll('.hacker-text');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const effect = new HackerEffect(el);
                    effect.run();

                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.1 });

        titles.forEach(el => observer.observe(el));
    }

    const FORMSPREE_ID = "mqargajo";
    const ENDPOINT = "https://formspree.io/f/" + FORMSPREE_ID;

    const form = document.getElementById("terminalForm");
    const btn = document.querySelector(".cmd-btn");

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            btn.innerHTML = "[ TRANSMITTING... ]";
            btn.style.opacity = "0.7";
            btn.disabled = true;

            const formData = new FormData(form);

            fetch(ENDPOINT, {
                method: "POST",
                body: formData,
                headers: { 'Accept': 'application/json' }
            })
                .then(response => {
                    if (response.ok) {
                        form.reset();
                        btn.innerHTML = "[ EXECUTE_PROTOCOL ]";
                        const successMsg = document.createElement("div");
                        successMsg.className = "cmd-line";
                        successMsg.style.color = "#10b981";
                        successMsg.style.marginTop = "1rem";
                        successMsg.innerHTML = "> SYSTEM: PACKET SECURED. CONNECTION CLOSED.";
                        form.appendChild(successMsg);
                        setTimeout(() => successMsg.remove(), 5000);
                    } else {
                        throw new Error('Network error');
                    }
                })
                .catch(error => {
                    btn.innerHTML = "[ RETRY ]";
                    const errorMsg = document.createElement("div");
                    errorMsg.className = "cmd-line";
                    errorMsg.style.color = "#ef4444";
                    errorMsg.style.marginTop = "1rem";
                    errorMsg.innerHTML = "> ERROR: SIGNAL LOST. CHECK CONNECTION.";
                    form.appendChild(errorMsg);
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.style.opacity = "1";
                });
        });
    }

});
