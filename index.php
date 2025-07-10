<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Awarcrown</title>
        <link rel="icon" href="Login/images/black_logo.png" />
        <link rel="stylesheet" href="stylesheet/cybertron7mainpage.css" />
        <link rel="icon" href="https://cybertron7.in/images/black_logo.png" />
    </head>
    <body>
        <header class="header">
            <nav class="nav-container">
                <div class="companynameandimg-container">
                    <img src="https://cybertron7.in/images/black_logo.png" alt="awarcrown-logo" />
                    <p class="logo" style = "cursor:default">Awarcrown</p>
                </div>
                <div class="nav-menu" id="navMenu">
                    <a href="#home" class="nav-link active">Home</a><a href="#projects" class="nav-link">Projects</a><a href="https://www.cybertron7.in/Login/aboutus.awc" class="nav-link">About</a>
                    <a href="https://cybertron7.in/Login/feedback-session.awc" class="nav-link" target = "_blank">Contact</a>
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
        <main>
            <div class="overlay" id="overlay"></div>
            <div class="update-popup" id="updatePopup">
                <p><strong>Important Update:</strong>We've rebranded from Cybertron7 to Awarcrown Corporations and the domain name will be updated soon to reflect our evolving vision. Explore our new identity!</p>
                <button onclick="closePopup()">Got It</button>
            </div>
            <section id="home" class="homesection">
                <div class="homesection-container">
                    <div class="homesection-content">
                        <h1 class="homesection-title">Welcome to <span class="accent">Awarcrown</span></h1>
                        <p class="homesection-text">Transforming Complexity into Simplicity: Empowering Innovators, Driving Startups, and Making AI Accessible for a Smarter Tomorrow</p>
                        <div class="homesection-buttons">
                            <a class="btn-primary-projects" href="#projects">View Projects</a><button class="btn-secondary" onclick='window.alert(" Our Join Us feature is coming soon! Stay tuned for updates!")'>Join Us</button>
                        </div>
                    </div>
                </div>
                <div class="homesection-shape"></div>
            </section>
            <section>
                <div class="content-grid">
                    <div class="main-content">
                        <div class="text-content">
                            <h3>Who We Are</h3>
                            <p>
                                At Awarcrown, we are a dynamic team of innovators, dedicated to advancing the field of Innovation and AI. Our mission is to empower businesses and individuals with cutting-edge solutions that protect and
                                transform. Our diverse team brings together expertise from technology, security, and entrepreneurship, working together to build a safer, more connected future.
                            </p>
                        </div>
                        <div class="whoweareimagecontainer">
                            <div class="whoweareimagecircle">
                                <div class="center-image"><img src="images/black_logo.png" alt="Profile" /></div>
                                <div class="dot-pattern"></div>
                            </div>
                        </div>
                    </div>
                    <div class="values-grid">
                        <div class="value-card">
                            <div class="icon-wrapper purple">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                            </div>
                            <h4>Innovation First</h4>
                            <p>Pushing boundaries with creative solutions</p>
                        </div>
                        <div class="value-card">
                            <div class="icon-wrapper blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h4>Team Spirit</h4>
                            <p>Collaboration drives our success</p>
                        </div>
                        <div class="value-card">
                            <div class="icon-wrapper green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <h4>Quality Focus</h4>
                            <p>Excellence in every detail</p>
                        </div>
                        <div class="value-card">
                            <div class="icon-wrapper orange">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M16 12l-4 4-4-4"></path>
                                    <path d="M12 8v7"></path>
                                </svg>
                            </div>
                            <h4>Forward Thinking</h4>
                            <p>Always looking to the future</p>
                        </div>
                    </div>
                    <div class="mission-card">
                        <div class="mission-content">
                            <h3>Our Mission</h3>
                            <h2>From complexity to simplicity making AI accessible to everyone</h2>
                            <p>
                                Our company's mission is to transform the complexity of AI into simple, user-friendly solutions that everyone can understand. To empower individuals and businesses with innovative solutions that drive growth
                                and security.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="projects-section" id="projects">
                <h3>Ongoing Projects</h3>
                <div class="projects-section-container">
                    <div class="projects-container-1">
                        <div class="project-cards">
                            <span class="project-tag">Startups Club</span>
                            <h2 class="project-title">Ideaship</h2>
                            <p class="project-description">An advanced digital platform connecting students and aspiring entrepreneurs to form teams, share startup ideas, and access startup mentorship, latest startup News.</p>
                            <div class="buttons"><button class="btn-primary" onclick='window.location.href="https://cybertron7.in/Startups/home.awc"' target="_blank">Visit Site</button></div>
                        </div>
                        <div class="project-cards">
                            <span class="project-tag">Tech Skills Development</span>
                            <h2 class="project-title">Programming Learning Website</h2>
                            <p class="project-description">A comprehensive platform for learning programming, offering structured courses, tutorials, and resources for beginners to advanced learners, empowering individuals.</p>
                            <div class="buttons"><button class="btn-primary" onclick="learningplatform()">Visit Site</button></div>
                        </div>
                    </div>
                    <div class="projects-image-container"><img src="images/projectimg.png" alt="program-img" /></div>
                    <div class="projects-container-2">
                        <div class="project-cards">
                            <span class="project-tag">Artificial Intelligence</span>
                            <h2 class="project-title">Krits AI</h2>
                            <p class="project-description">Advanced AI solutions platform offering cutting-edge machine learning models and natural language processing capabilities for businesses.</p>
                            <div class="buttons"><button class="btn-primary" onclick='window.alert("Krits AI is in the development stage.")'>Visit Site</button></div>
                        </div>
                        <div class="project-cards">
                            <span class="project-tag">Algorithm Development & Playground</span>
                            <h2 class="project-title">Algorithm Innovation Hub</h2>
                            <p class="project-description">An advanced platform for algorithm development, featuring an interactive playground for practicing algorithms. Future plans include the creation of new innovative algorithms.</p>
                            <div class="project-buttons"><button class="btn-primary" onclick='window.location.href="https://cybertron7.in/algorithms/algorithmsinterface.awc"'>Visit Site</button></div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="working-process">
                <h3 class="working-processh3">WORKING PROCESS</h3>
                <div class="separator projectsheaderseperator"></div>
                <div class="process-timeline">
                <div class="process-step">
                    <div class="step-number">01</div>
                    <div class="step-content">
                        <h3>Identify</h3>
                        <p>We identify actionable opportunities and align our strategies tailored to you.</p>
                    </div>
                    <div class="step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">02</div>
                    <div class="step-content">
                        <h3>Create</h3>
                        <p>Our team designs scalable and sustainable solutions for the identified problem.</p>
                    </div>
                    <div class="step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">03</div>
                    <div class="step-content">
                        <h3>Develop</h3>
                        <p>We develop the solution through the technology and test for efficiency.</p>
                    </div>
                    <div class="step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 18 22 12 16 6"/>
                            <polyline points="8 6 2 12 8 18"/>
                        </svg>
                    </div>
                </div>

                <div class="process-step">
                    <div class="step-number">04</div>
                    <div class="step-content">
                        <h3>Scale</h3>
                        <p>Expanding the solution to maximize impact and to reach throughout the target customers.</p>
                    </div>
                    <div class="step-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            <polyline points="7.5 4.21 12 6.81 16.5 4.21"/>
                            <polyline points="7.5 19.79 7.5 14.6 3 12"/>
                            <polyline points="21 12 16.5 14.6 16.5 19.79"/>
                            <polyline points="12 22.81 12 17"/>
                        </svg>
                    </div>
                </div>
            </div>
            </section>
            <section class="our-initial-step">
                <div class="our-initial-step-text-content">
                    <h3 class="our-initial-step-section-title">Our Initial Step</h3>
                    <p>
                        Welcome to Awarcrown's journey where our dreams began with a vision to democratize artificial intelligence and revolutionize education. Our initial step marks the foundation of a transformative path, driven by our
                        commitment to innovation, learning, and community.
                    </p>
                    <p>
                        Our journey started with the goal of creating a supportive ecosystem for aspiring entrepreneurs and students. We envisioned a space where ideas could flourish, and where the power of technology could be harnessed to
                        make a meaningful impact. This vision has now evolved into a vibrant community of like-minded individuals, eager to challenge the status quo and drive positive change.
                    </p>
                    <div class="design-table">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="study">
                                <rect width="64" height="64" />
                                <g id="smoke">
                                    <path id="smoke-2" d="M9 21L9.55279 19.8944C9.83431 19.3314 9.83431 18.6686 9.55279 18.1056L9 17L8.44721 15.8944C8.16569 15.3314 8.16569 14.6686 8.44721 14.1056L9 13" stroke="#797270" />
                                    <path id="smoke-1" d="M6.5 22L7.05279 20.8944C7.33431 20.3314 7.33431 19.6686 7.05279 19.1056L6.5 18L5.94721 16.8944C5.66569 16.3314 5.66569 15.6686 5.94721 15.1056L6.5 14" stroke="#797270" />
                                </g>
                                <g id="laptop">
                                    <rect id="laptop-base" x="17" y="28" width="20" height="3" fill="#F3F3F3" stroke="#453F3C" stroke-width="2" />
                                    <rect id="laptop-screen" x="18" y="17" width="18" height="11" fill="#5A524E" stroke="#453F3C" stroke-width="2" />
                                    <rect id="line-1" x="20" y="19" width="14" height="1" fill="#F78764" />
                                    <rect id="line-2" x="20" y="21" width="14" height="1" fill="#F9AB82" />
                                    <rect id="line-3" x="20" y="23" width="14" height="1" fill="#F78764" />
                                    <rect id="line-4" x="20" y="25" width="14" height="1" fill="#F9AB82" />
                                </g>
                                <g id="cup">
                                    <rect id="Rectangle 978" x="5" y="24" width="5" height="7" fill="#CCC4C4" stroke="#453F3C" stroke-width="2" />
                                    <path id="Ellipse 416" d="M11 28C12.1046 28 13 27.1046 13 26C13 24.8954 12.1046 24 11 24" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 996" x="6" y="25" width="3" height="1" fill="#D6D2D1" />
                                </g>
                                <g id="books">
                                    <rect id="Rectangle 984" x="58" y="27" width="4" height="14" transform="rotate(90 58 27)" fill="#B16B4F" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 985" x="56" y="23" width="4" height="14" transform="rotate(90 56 23)" fill="#797270" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 986" x="60" y="19" width="4" height="14" transform="rotate(90 60 19)" fill="#F78764" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 993" x="47" y="20" width="12" height="1" fill="#F9AB82" />
                                    <rect id="Rectangle 994" x="43" y="24" width="12" height="1" fill="#54504E" />
                                    <rect id="Rectangle 995" x="45" y="28" width="12" height="1" fill="#804D39" />
                                </g>
                                <g id="desk">
                                    <rect id="Rectangle 973" x="4" y="31" width="56" height="5" fill="#797270" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 987" x="10" y="36" width="30" height="6" fill="#797270" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 975" x="6" y="36" width="4" height="24" fill="#797270" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 974" x="40" y="36" width="18" height="24" fill="#797270" stroke="#453F3C" stroke-width="2" />
                                    <line id="Line 129" x1="40" y1="48" x2="58" y2="48" stroke="#453F3C" stroke-width="2" />
                                    <line id="Line 130" x1="22" y1="39" x2="28" y2="39" stroke="#453F3C" stroke-width="2" />
                                    <line id="Line 142" x1="46" y1="42" x2="52" y2="42" stroke="#453F3C" stroke-width="2" />
                                    <line id="Line 131" x1="46" y1="54" x2="52" y2="54" stroke="#453F3C" stroke-width="2" />
                                    <rect id="Rectangle 988" x="11" y="37" width="28" height="1" fill="#54504E" />
                                    <rect id="Rectangle 992" x="5" y="32" width="54" height="1" fill="#9E9492" />
                                    <rect id="Rectangle 989" x="7" y="37" width="2" height="1" fill="#54504E" />
                                    <rect id="Rectangle 990" x="41" y="37" width="16" height="1" fill="#54504E" />
                                    <rect id="Rectangle 991" x="41" y="49" width="16" height="1" fill="#54504E" />
                                    <line id="Line 143" y1="60" x2="64" y2="60" stroke="#453F3C" stroke-width="2" />
                                </g>
                            </g>
                        </svg>
                        <div class="founders-quote">
                            <h1>The strongest pillars are built to withstand the greatest pressure.</h1>
                            <p><strong>~Aditya||C.E.O</strong></p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-grid">
                    <div class="brand-column">
                        <div class="brand"><img src="/images/logo-2.png" alt="" class="brand-icon" /><span class="brand-name">Awarcrown Corporations</span></div>
                        <p class="brand-description">Awarcrown Corporation is a multi sector company focused on innovation, education, and startup ecosystem development.</p>
                    </div>
                    <div class="nav-column">
                        <h3 class="footer-heading">Explore</h3>
                        <div class="footer-nav-grid">
                            <div class="footer-nav-list">
    <ul>
        <li><a href="https://www.cybertron7.in/Login/aboutus.awc" class="footer-nav-link" target="_blank">About Us</a></li>
        <li><a href="https://cybertron7.in/Startups/home.awc" class="footer-nav-link" target="_blank">Ideaship</a></li>
        <li><a class="footer-nav-link" onclick="learningplatform()" style = "cursor : pointer">Programming learning</a></li>
        <li><a href="https://cybertron7.in/algorithms/algorithmsinterface.awc" class="footer-nav-link" target="_blank">Algorithm Innovation hub</a></li>
        <li><a class="footer-nav-link" onclick='alert("Krits AI is in the development stage.")' style = "cursor : pointer">Krits AI</a></li>
    </ul>
</div>

                        </div>
                    </div>
                    <div class="contact-column">
                        <h3 class="footer-heading">Get in Touch</h3>
                        <ul class="contact-list">
                            <li class="contact-item">
                                <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <div>
                                    <p class="contact-label">Email Us</p>
                                    <a href="mailto:support@cybertron7.in" class="contact-link">support@cybertron7.in</a>
                                </div>
                            </li>
                            <li class="contact-item">
                                <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                                    ></path>
                                </svg>
                                <div>
                                    <p class="contact-label">Call Us</p>
                                    <a href="tel:9676832291" class="contact-link">+91 9676832291</a>
                                </div>
                            </li>
                        </ul>
                        <div class="social-links">
                            <a href="https://www.linkedin.com/company/awarcrown/" target="/blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-linkedin" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"
                                    />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/awarcrown/" target="/blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"
                                    />
                                </svg>
                            </a>
                            <a href="https://chat.whatsapp.com/JTHXEzPfPad2oLl94D87WD" target="/blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"
                                    />
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
                                <li><a href="https://cybertron7.in/policy.awc" class="legal-link" target = "_blank">Privacy</a></li>
                                <li><a href="https://cybertron7.in/cookie.awc" class="legal-link" target = "_blank">Cookies</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="loading-screen" id="loading-screen"><img src="images/newload.gif" alt="Loading" width="150px" height="150px" /></div>
        <script>
            function setCookie(e, n, t) {
                var o,
                    l = "";
                t && ((o = new Date()).setTime(o.getTime() + 24 * t * 60 * 60 * 1e3), (l = "; expires=" + o.toUTCString())), (document.cookie = e + "=" + (n || "") + l + "; path=/");
            }
            function getCookie(e) {
                for (var n = e + "=", t = document.cookie.split(";"), o = 0; o < t.length; o++) {
                    for (var l = t[o]; " " == l.charAt(0); ) l = l.substring(1, l.length);
                    if (0 == l.indexOf(n)) return l.substring(n.length, l.length);
                }
                return null;
            }
            function showPopup() {
                (document.getElementById("updatePopup").style.display = "block"), (document.getElementById("overlay").style.display = "block");
            }
            function closePopup() {
                (document.getElementById("updatePopup").style.display = "none"), (document.getElementById("overlay").style.display = "none"), setCookie("updateShown", "true", 365);
            }
            function learningplatform() {
                window.location.href = "https://cybertron7.in/Learn-programming/main-interface-session.awc";
            }
            window.addEventListener("load", function () {
                (document.getElementById("loading-screen").style.display = "none"), getCookie("updateShown") || showPopup();
            }),
                window.addEventListener("scroll", function () {
                    const e = document.querySelector("header");
                    0 < window.scrollY ? (e.style.boxShadow = "0px 0px 4px black") : (e.style.boxShadow = "none");
                });
            const navToggle = document.getElementById("navToggle"),
                navMenu = document.getElementById("navMenu");
            navToggle.addEventListener("click", () => {
                navMenu.classList.toggle("active");
            });
        </script>
    </body>
</html>
