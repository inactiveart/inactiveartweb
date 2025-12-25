<?php
/**
 * @architect    Inactiveart (System Architect & UI Engineer)
 * @project      Inactiveart Official Portfolio (V1.0)
 * @copyright    2025 Inactiveart. All rights reserved.
 * @description  Main portfolio interface and digital architecture showcase.
 */

header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; style-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com; img-src 'self' data:; font-src 'self' https://fonts.gstatic.com; connect-src 'self';");
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    if ($_SERVER['SERVER_NAME'] !== 'localhost') {
        $httpsUrl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $httpsUrl, true, 301);
        exit();
    }
}

$json = file_get_contents('data.json');
$data = json_decode($json, true);
if (!$data) {
    die('Error loading data.');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#000000">
    <title>Inactiveart | Digital Architecture & Minimalist Systems</title>
    <meta name="description"
        content="Sessizliğin gücü. Inactiveart, dijital gürültüyü filtreleyen, yüksek performanslı ve minimalist web sistemleri tasarlar. CRM, Arayüz ve Marka Kimliği.">
    <meta name="keywords"
        content="Minimalist Web Design, Digital Architecture, UI/UX Design, Inactiveart, System Design, Frontend Development, Cyberpunk Estetik">
    <meta name="author" content="Inactiveart Systems">
    <meta name="copyright" content="Inactiveart © 2025">
    <meta name="generator" content="Inactiveart Core Engine">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="https://www.inactiveart.com/">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.inactiveart.com/">
    <meta property="og:title" content="Inactiveart | The Power of Digital Silence">
    <meta property="og:description"
        content="Karmaşayı kodluyoruz, siz sonucu görüyorsunuz. Minimalist ve fütüristik dijital mimari.">
    <meta property="og:image" content="https://www.inactiveart.com/assets/images/social-card.jpg">
    <meta property="og:site_name" content="Inactiveart">
    <meta property="og:locale" content="tr_TR">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Inactiveart | Digital Architecture">
    <meta name="twitter:description" content="Sessizliğin gücü. Minimalist sistemler ve arayüzler.">
    <meta name="twitter:image" content="https://www.inactiveart.com/assets/images/social-card.jpg">

    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ProfessionalService",
      "name": "Inactiveart",
      "url": "https://www.inactiveart.com",
      "logo": "https://www.inactiveart.com/assets/images/logo.png",
      "image": "https://www.inactiveart.com/assets/images/social-card.jpg",
      "description": "Minimalist ve fütüristik web arayüzleri, dijital mimari ve sistem tasarımı.",
      "foundingDate": "2024",
      "priceRange": "$$$",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Istanbul",
        "addressCountry": "TR"
      },
      "sameAs": [
        "https://www.instagram.com/inactiveart",
        "https://www.linkedin.com/company/inactiveart",
        "https://github.com/inactiveart"
      ]
    }
    </script>

    <link rel="stylesheet" href="style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;500;700&family=Fira+Code:wght@400;700&display=swap"
        rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>
</head>

<body>
    <!-- Skip to Content Link for Accessibility -->
    <a href="#main-content" class="skip-link">Ana içeriğe geç</a>
    <!-- Preloader -->
    <div id="preloader" role="status" aria-busy="true" aria-live="polite">
        <span class="sr-only">Sayfa yükleniyor, lütfen bekleyin...</span>
        <div class="terminal-content">
            <span id="log-message">_</span>
            <span class="cursor">_</span>
        </div>
    </div>

    <!-- Sound Assets -->
    <audio id="uiClick" preload="auto" src="assets/audio/ui-click.ogg"></audio>

    <div class="code-scatter">
        <div class="snippet pos-1">const flow = true;</div>
        <div class="snippet pos-2">system.init();</div>
        <div class="snippet pos-3">return void;</div>
        <div class="snippet pos-4">0x14F3A</div>
        <div class="snippet pos-5">&lt;kernel&gt;</div>
        <div class="snippet pos-6">await response;</div>
        <div class="snippet pos-7">if (err) exit;</div>
        <div class="snippet pos-8">import { null }</div>
        <div class="snippet pos-9">while(1) {}</div>
        <div class="snippet pos-10">404_NOT_FOUND</div>
        <div class="snippet pos-11">
            function loop() {<br>
            &nbsp;&nbsp;render();<br>
            }
        </div>
        <div class="snippet pos-12">
            class Entity {<br>
            &nbsp;&nbsp;constructor() {}<br>
            }
        </div>
        <div class="snippet pos-13">background: #000;</div>
        <div class="snippet pos-14">Array.from(data)</div>
        <div class="snippet pos-15">&lt;/div&gt;</div>
        <div class="snippet pos-16">console.log("Error");</div>
        <div class="snippet pos-17">fetch('/api/status')</div>
        <div class="snippet pos-18">// TODO: Sleep</div>
        <div class="snippet pos-19">catch(e) {}</div>
        <div class="snippet pos-20">process.env</div>
        <div class="snippet pos-21">Stack Overflow</div>
        <div class="snippet pos-22">Segmentation Fault</div>
        <div class="snippet pos-23">echo "hello";</div>
        <div class="snippet pos-24">0xFFFFFF</div>
        <div class="snippet pos-25">sudo reboot</div>
    </div>

    <header class="site-header reveal" role="banner" aria-label="Site header">
        <div class="site-logo"><span class="inactive-prefix">INACTIVE</span><span class="art-suffix">ART</span></div>
        <div class="header-actions">
            <div class="social-icons" id="dynamic-socials"></div>
            <nav role="navigation" aria-label="Main navigation">
                <a href="index.php">HOME</a>
                <a href="identity.html">IDENTITY</a>
                <a href="contact.html">CONTACT</a>
            </nav>
        </div>
    </header>

    <main id="main-content">

        <!-- Hero Section -->
        <section id="intro" class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title reveal-stagger hacker-text" data-value="We create. You stay inactive.">
                    We create. You stay inactive.
                </h1>
                <div class="code-subtitle reveal-stagger">
                    // SYSTEM: Arkaplan işlemleri yönetiliyor. Siz inaktif kalın.<span class="cursor">_</span>
                </div>
            </div>
        </section>

        <!-- Philosophy Section -->
        <section id="about">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title hacker-text" data-value="PHILOSOPHY">PHILOSOPHY</h2>
                    <div class="section-line"></div>
                </div>
                <div class="reveal-text">
                    <p class="reveal-stagger"
                        style="font-size: 2rem; margin-left: 5%; line-height: 1.4; font-family: 'Courier New', Courier, monospace;">
                        <?php echo $data['philosophy']['content']; ?>
                    </p>
                </div>
            </div>
        </section>

        <section id="works">
            <div class="container" style="width: 100%;">
                <div class="section-header text-right">
                    <h2 class="section-title hacker-text" data-value="SELECTED WORKS">SELECTED WORKS</h2>
                    <div class="section-line"></div>
                </div>

                <?php
                if (isset($data['portfolio'])):
                    foreach ($data['portfolio'] as $catKey => $category):
                        ?>
                        <div class="category-row reveal-stagger">
                            <div class="category-header">
                                <div class="cat-titles">
                                    <h3>
                                        <?php echo $category['title_en']; ?>
                                        <span class="tr-title">/ <?php echo $category['title_tr']; ?></span>
                                    </h3>
                                </div>
                                <div class="cat-desc"><?php echo $category['desc']; ?></div>
                            </div>

                            <div class="portfolio-reel">
                                <?php if (isset($category['items'])):
                                    foreach ($category['items'] as $item): ?>
                                        <article class="work-item">
                                            <figure>
                                                <?php
                                                $imgPath = $item['img'];
                                                $pathInfo = pathinfo($imgPath);
                                                $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
                                                ?>
                                                <picture>
                                                    <source srcset="<?php echo $webpPath; ?>" type="image/webp">
                                                    <img src="<?php echo $imgPath; ?>" alt="<?php echo $item['title']; ?>"
                                                        loading="lazy" decoding="async">
                                                </picture>
                                            </figure>
                                            <h4 class="work-title"><?php echo $item['title']; ?></h4>
                                        </article>
                                    <?php endforeach; endif; ?>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>



    </main>

    <footer class="site-footer" role="contentinfo" aria-label="Site footer">
        <div class="footer-content"
            style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
            <p>
                &copy; 2025 <span style="font-family: 'Fira Code', monospace; font-weight:700;">INACTIVEART</span>.
                ALL SYSTEMS OPERATIONAL.
            </p>
            <!-- Sound Toggle -->
            <div id="soundToggle" class="sound-toggle" role="button" aria-pressed="false" aria-label="Toggle sound"
                style="cursor: pointer; color: #555; font-size: 0.8rem; letter-spacing: 2px;">
                SOUND: [ <span id="soundStatus" style="color: #3b82f6;">OFF</span> ]
            </div>
            <!-- Admin Link -->
            <a href="admin.php" style="font-size: 0.8rem; opacity: 0.2; color: #555; text-decoration: none;">System</a>
        </div>
    </footer>

    <!-- Custom Cursor Elements -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <script src="script.js"></script>
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.pointerEvents = 'none';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 1000);
                }
            }, 3500);
        });

        setTimeout(() => {
            const preloader = document.getElementById('preloader');
            if (preloader) { preloader.style.display = 'none'; }
        }, 5000);
    </script>
</body>

</html>