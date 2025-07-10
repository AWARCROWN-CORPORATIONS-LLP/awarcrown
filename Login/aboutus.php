<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Awarcrown</title>
    <link rel="stylesheet" href="aboutus.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="images/black_logo.png">
</head>

<body>
    <header class="header">
        <nav class="nav-container">
            <div class="companynameandimg-container">
                <img src="/images/black_logo.png" alt="awarcrown-logo" />
                <p class="logo" style = "cursor:pointer" onclick="goToHome()">Awarcrown</p>
            </div>
            <div class="nav-menu" id="navMenu">
                <a href="https://cybertron7.in" target="_blank" class="nav-link">Home</a><a href="#projects"
                    class="nav-link">Projects</a><a href="https://www.cybertron7.in/Login/aboutus.awc" target="_blank"
                    class="nav-link active">About</a>
                <a href="https://cybertron7.in/Login/feedback-session.awc" class="nav-link" target="_blank">Contact</a>
            </div>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80" width="30" height="30" fill="currentColor">
                    <rect width="80" height="8" rx="5"></rect>
                    <rect y="30" width="90" height="8" rx="5"></rect>
                    <rect y="60" width="100" height="8" rx="5"></rect>
                </svg>
            </button>
        </nav>
    </header>
    <section id="home" class="homesection">
        <div class="homesection-container">
            <div class="homesection-content">
                <h1 class="homesection-title">About&nbsp;<span class="accent">Awarcrown</span></h1>
                <p class="homesection-text">Awarcrown Corporations (Formerly known as CYBERTRON7) - Where Innovation
                    meets Passion</p>
            </div>
        </div>
    </section>
    <section class="projects-section">
        <div class="projects-section-container">
            <div class="projects-container-1">
                <div class="project-cards">
                    <h2 class="project-title">Mission</h2>
                    <p class="project-description">To empower students and aspiring innovators by providing platforms
                        that foster learning through passion, creativity, and real-world experience. Reshaping education
                        and entrepreneurship through technology.</p>
                </div>
                <div class="project-cards">
                    <h2 class="project-title">Vision</h2>
                    <p class="project-description">To build a global empire that drives innovation across education,
                        industry, and artificial intelligence - shaping the future by empowering minds, transforming
                        businesses, and leading technological revolutions.</p>
                </div>
            </div>
            <div class="projects-image-container"><img src="images/projectimg.png" alt="program-img" /></div>
            <div class="projects-container-2">
                <div class="project-cards">
                    <h2 class="project-title">About Us</h2>
                    <p class="project-description">Awarcrown Corporations LLP is a future-driven company where
                        innovation meets passion. We create platforms in education, industry, and AI. Empowering people
                        to follow their passion, disrupt systems, and redefine what's possible.</p>
                </div>
                <div class="project-cards">
                    <h2 class="project-title">Core Values</h2>
                    <p class="project-description">
                        <li class="core-valueli">Innovation First</li>
                        <li class="core-valueli">Team Spirit</li>
                        <li class="core-valueli">Quality Focus</li>
                        <li class="core-valueli">Forward Thinking</li>
                        <li class="core-valueli">Forward Thinking</li>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="our-journey-container">
        <h1>Our Journey</h1>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="year">2022</div>
                    <h3>Company Founded</h3>
                    <p>Awarcrown Corporations was founded as Cybertron7 with a vision to make AI and technology
                        accessible
                        to everyone.
                    </p>
                </div>
                <div class="timeline-circle"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="year">2024</div>
                    <h3>Growth</h3>
                    <p>Launched our first learning platforms and began supporting students in their learning journey.
                    </p>
                </div>
                <div class="timeline-circle"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="year">2025</div>
                    <h3>Expansion</h3>
                    <p>We officially recognised as Awarcrown corporations LLP by government of india.
                    </p>
                </div>
                <div class="timeline-circle"></div>
            </div>
        </div>
    </section>
    <section class="our-projects-container" id="projects">
        <h1>Projects</h1>
        <div class="services-grid">
            <div class="service-card">
                <div class="card-header">
                    <div class="icon-container ideaship-icon">
                        <img src="images/Ideaship_icon.png" alt="ideaship">
                    </div>
                    <div class="card-content">
                        <h2 class="card-title">Ideaship</h2>
                        <p class="card-tagline">Where aspiring entrepreneurs meet and launch</p>
                    </div>
                </div>
                <p class="card-description">
                    An advanced digital platform for aspiring entrepreneurs to form teams, share innovative ideas, and
                    connect using powerful tools.
                </p>
                <button class="visit-btn" onclick="window.location.href = 'https://cybertron7.in/Startups/home.awc'">
                    Visit Site
                    <svg class="external-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
                    </svg>
                </button>
            </div>
            <!-- <div class="service-card">
                <div class="card-header">
                    <div class="icon-container ideaship-icon">
                        <img src="images/artificial-intelligence.png" alt="kritsai">
                    </div>
                    <div class="card-content">
                        <h2 class="card-title">Kris AI</h2>
                        <p class="card-tagline">Intelligent solutions made accessible</p>
                    </div>
                </div>
                <p class="card-description">
                    Advanced AI solutions platform offering cutting-edge machine learning models and natural language
                    processing capabilities.
                </p>
                <button class="visit-btn">
                    Visit Site
                    <svg class="external-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
                    </svg>
                </button>
            </div> -->
            <div class="service-card">
                <div class="card-header">
                    <div class="icon-container ideaship-icon">
                        <img src="images/Programming.png" alt="programming">
                    </div>
                    <div class="card-content">
                        <h2 class="card-title">Programming Learning Website</h2>
                        <p class="card-tagline">Master coding through interactive learning</p>
                    </div>
                </div>
                <p class="card-description">
                    A comprehensive platform for learning programming, offering structured courses, tutorials, and
                    exercises for beginners to experts.
                </p>
                <button class="visit-btn" onclick="learningplatform()">
                    Visit Site
                    <svg class="external-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
                    </svg>
                </button>
            </div>
            <div class="service-card">
                <div class="card-header">
                    <div class="icon-container ideaship-icon">
                        <img src="images/arcanyx.png" alt="arcanyx">
                    </div>
                    <div class="card-content">
                        <h2 class="card-title">Arcanyx</h2>
                        <p class="card-tagline">Advancing algorithmic research and development</p>
                    </div>
                </div>
                <p class="card-description">
                    An advanced platform for algorithm development, research, and innovation. Future plans include live
                    creation of new encoded algorithms.
                </p>
                <button class="visit-btn"
                    onclick="window.location.href = 'https://cybertron7.in/algorithms/algorithmsinterface.awc'">
                    Visit Site
                    <svg class="external-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z" />
                    </svg>
                </button>
            </div>
        </div>
    </section>
    <section class="saas-container">
        <div class="content-grid">
            <div class="main-content">
                <div class="text-content">
                    <h3>Services (SaaS)</h3>
                    <p>
                        Awarcrown Corporations LLP operates as a Software as a Service (SaaS) company, delivering
                        scalable and innovative digital solutions tailored for the modern world. We specialize in
                        building reliable and secure services based on your requirements. We build custom software
                        projects for clients, helping them bring their ideas to life with powerful, future-ready
                        technology.
                    </p>
                </div>
                <div class="whoweareimagecontainer">
                    <img src="images/saas.jpg" alt="" style="height : 300px;">
                </div>
            </div>
            <div class="values-grid">
                <div class="service-app-card">
                    <div class="service-app-icon">
                        <img src="images/androiddevelopment.png" alt="" style="width: 50px;">
                    </div>

                    <h2 class="service-app-title">Web Development</h2>

                    <p class="service-app-description">
                        Scalable and responsive web applications tailored to your needs
                    </p>

                    <div class="service-app-features">
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">HTML,CSS and JS</span>
                        </div>

                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">React JS, Node JS & PhP</span>
                        </div>

                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">REST, GraphQL API etc</span>
                        </div>

                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">DBMS</span>
                        </div>
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">Security Layers & Maintainance</span>
                        </div>
                    </div>
                </div>
                <div class="service-app-card">
                    <div class="service-app-icon">
                        <img src="images/webdevelopment.png" alt="" style="width: 50px;">
                    </div>
                    <h2 class="service-app-title">App Development</h2>
                    <p class="service-app-description">
                        Scalable and responsive mobile applications tailored to your needs
                    </p>
                    <div class="service-app-features">
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">Kotlin & Flutter</span>
                        </div>
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">Spring Boot & Node JS</span>
                        </div>
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">REST, GraphQL API etcs</span>
                        </div>
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">DBMS</span>
                        </div>
                        <div class="app-feature-item">
                            <div class="app-feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="app-feature-text">Security Layers & Maintainance</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-team-container">
        <h1>Our Team</h1>
        <div class="team-grid">
            <div class="team-card">
                <span class="card-corner-decor"></span>
                <div class="avatar">CA</div>
                <h3 class="name">CH Aditya</h3>
                <p class="title">Founder/Chief Executive Officer</p>
                <div class="team-social-links">
                    <a href="https://www.linkedin.com/in/chitti-boyina-aditya-manikanth-sai-6372082a9/" target="_blank" class="team-social-icon linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="team-card">
                <span class="card-corner-decor"></span>
                <div class="avatar">NB</div>
                <h3 class="name">J Naveen Babu</h3>
                <p class="title">Co founder/president</p>
                <div class="team-social-links">
                    <a href="https://www.linkedin.com/in/naveen-jupalli-78b869268/" target="_blank" class="team-social-icon linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="team-card">
                <span class="card-corner-decor"></span>
                <div class="avatar">SJ</div>
                <h3 class="name">A Sai janardhan</h3>
                <p class="title">Cheif Technology Officer</p>
                <div class="team-social-links">
                    <a href="https://www.linkedin.com/in/alapati-g-p-s-sai-janardhan-a910912aa/" target="_blank" class="team-social-icon linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="team-card">
                <span class="card-corner-decor"></span>
                <div class="avatar">SN</div>
                <h3 class="name">S Navadeep</h3>
                <p class="title">Cheif Compliance Officer</p>
                <div class="team-social-links">
                    <a href="https://www.linkedin.com/in/navadeep-sunkara-538397259/" target="_blank" class="team-social-icon linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="team-card">
                <span class="card-corner-decor"></span>
                <div class="avatar">KA</div>
                <h3 class="name">K Akash</h3>
                <p class="title">Cheif Financial Officer</p>
                <div class="team-social-links">
                    <a href="https://www.linkedin.com/in/k-sri-akash-36a868268/" target="_blank" class="team-social-icon linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="team-card">
                <span class="card-corner-decor"></span>
                <div class="avatar">TR</div>
                <h3 class="name">K Tejeswar Reddy</h3>
                <p class="title">Administrator</p>
                <div class="team-social-links">
                    <a href="https://www.linkedin.com/in/kalluru-tejeswar-reddy-a9b65b269/" target="_blank" class="team-social-icon linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="brand-column">
                    <div class="brand"><img src="/images/logo-2.png" alt="" class="brand-icon" /><span
                            class="brand-name">Awarcrown Corporations</span></div>
                    <p class="brand-description">Awarcrown Corporation is a multi sector company focused on innovation,
                        education, and startup ecosystem development.</p>
                </div>
                <div class="nav-column">
                    <h3 class="footer-heading">Explore</h3>
                    <div class="footer-nav-grid">
                        <div class="footer-nav-list">
                            <ul>
                                <li><a href="https://www.cybertron7.in" class="footer-nav-link" target="_blank">Home</a>
                                </li>
                                <li><a href="https://cybertron7.in/Startups/home.awc" class="footer-nav-link"
                                        target="_blank">Ideaship</a></li>
                                <li><a class="footer-nav-link" onclick="learningplatform()"
                                        style="cursor : pointer">Programming learning</a></li>
                                <li><a href="https://cybertron7.in/algorithms/algorithmsinterface.awc"
                                        class="footer-nav-link" target="_blank">Algorithm Innovation hub</a></li>
                                <li><a class="footer-nav-link" onclick='alert("Krits AI is in the development stage.")'
                                        style="cursor : pointer">Krits AI</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="contact-column">
                    <h3 class="footer-heading">Get in Touch</h3>
                    <ul class="contact-list">
                        <li class="contact-item">
                            <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <div>
                                <p class="contact-label">Email Us</p>
                                <a href="mailto:support@cybertron7.in" class="contact-link">support@cybertron7.in</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            <div>
                                <p class="contact-label">Call Us</p>
                                <a href="tel:9676832291" class="contact-link">+91 9676832291</a>
                            </div>
                        </li>
                    </ul>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/company/awarcrown/" target="/blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                                class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/awarcrown/" target="/blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                                class="bi bi-instagram" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                            </svg>
                        </a>
                        <a href="https://chat.whatsapp.com/JTHXEzPfPad2oLl94D87WD" target="/blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                                class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path
                                    d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="bottom-bar">
                <div class="bottom-content">
                    <p class="copyright">2025 &copy; Awarcrown Corporations LLP. All rights reserved.</p>
                    <div class="legal-links">
                        <ul>
                            <li><a href="https://cybertron7.in/policy.awc" class="legal-link"
                                    target="_blank">Privacy</a></li>
                            <li><a href="https://cybertron7.in/cookie.awc" class="legal-link"
                                    target="_blank">Cookies</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="loading-screen" id="loading-screen">
        <img src="images/newload.gif" alt="Loading" width="150px" height="150px">
    </div>
    <script>
        window.addEventListener('load', function () {
            var loadingScreen = document.getElementById('loading-screen');
            loadingScreen.style.display = 'none';
        });
        function learningplatform() {
            window.location.href = "https://cybertron7.in/Learn-programming/main-interface-session.awc";
        }
        function goToHome() {
            window.location.href = "https://cybertron7.in/";
        }

        const navToggle = document.getElementById("navToggle"),
            navMenu = document.getElementById("navMenu");
        navToggle.addEventListener("click", () => {
            navMenu.classList.toggle("active");
        });
        
    </script>

</body>

</html>