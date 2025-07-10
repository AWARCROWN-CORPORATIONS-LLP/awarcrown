<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8" />
    <meta content="width=device-width,initial-scale=1" name="viewport" />
    <title>Awarcrown - Learn programming from scratch</title>
    <link href="main-interface.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&family=Source+Code+Pro:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" type="module"></script>
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" nomodule></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet" />
    <link href="media-main-interface.css" rel="stylesheet" />
    <script src="nonloginpage.js"></script>
    <link href="images/black_logo.png" rel="icon" />
    <nav class="nav-bar">
        <img src="/images/black_logo.png" alt="awarcrown-logo" height="40px" style="cursor: pointer;" width="40px" />
        <h1 id="heading">Awarcrown Programming</h1>
    </nav>
    <div class="main-container-1">
        <div><img src="images/programmer-image.png" class="programmer-image" alt="Programmer Image" /></div>
        <div class="main-container-1-inf">
            <h1 class="text-01">Learn programming from scratch</h1>
            <p class="start-inf">Explore the world of programming. Start your journey.</p>
        </div>
    </div>
    <div class="main-container-2">
        <div class="code-quote">
            <h2 class="text-02">Become a pro <span class="color-text">coder!</span></h2>
            <abbr title="Click to get started with courses">
                <div class="language-list">
                    <div class="language-list-items" id="python-id-1">
                        <a href="https://cybertron7.in/Learn-programming/pythoninterface-session.awc">
                            <div class="lang-logo-container"><img src="images/python_logo.png" class="logo-lang" alt="Python Logo" /></div>
                            <div class="item-name">Python</div>
                        </a>
                    </div>
                    <div class="language-list-items" id="java-id-1" style="cursor: pointer;">
                        <div class="lang-logo-container"><img src="images/java_logo.png" class="logo-lang" alt="Java Logo" /></div>
                        <div class="item-name">Java</div>
                    </div>
                    <div class="language-list-items" id="js-id-1" style="cursor: pointer;">
                        <div class="lang-logo-container"><img src="images/js_logo.png" class="logo-lang" alt="JavaScript Logo" /></div>
                        <div class="item-name">JavaScript</div>
                    </div>
                </div>
            </abbr>
        </div>
    </div>
    <section class="keyfeatures">
        <h2>Features for you</h2>
        <div class="keyfeatures-container">
            <img src="images/dialytutorials.png" class="dialytutorial-img" />
            <div class="keyfeatures-card">
                <h3>Daily Tutorials</h3>
                <p>Our daily tutorials are designed to build your coding skills incrementally.</p>
            </div>
            <img src="images/weeklytest.png" class="weeklytest-img" />
            <div class="keyfeatures-card">
                <h3>Weekly Challenges</h3>
                <p>Reinforce what you've learned with our weekly syntax challenges.</p>
            </div>
            <img src="images/progress.png" class="progress-img" />
            <div class="keyfeatures-card">
                <h3>Progress Tracking</h3>
                <p>Stay motivated and on track with our built-in achievement tracker.</p>
            </div>
        </div>
    </section>
    <section class="skillssection">
        <h2 class="skills-heading">Enhance your skills based on your Interest</h2>
        <div class="skillssectionmain-container">
            <div class="skillssection-container">
                <img src="images/technicalskills.png" class="technicalskills-img" />
                <div class="skillssection-card">
                    <h1>Technical Skills</h1>
                    <p>
                        Technical skills are the specific abilities you need to use tools and software effectively. For example, knowing how to use a programming language like Python or understanding how to work with data helps you build
                        and manage technology. These skills are essential for doing technical tasks and solving problems related to technology.
                    </p>
                </div>
            </div>
            <div class="skillssection-container" id="develop-section">
                <div class="skillssection-card">
                    <h1>Development Skills</h1>
                    <p>
                        Development skills are the abilities you need to create and improve software or applications. This includes writing code to make a program work, fixing issues, and figuring out how to make your projects better. These
                        skills are important for building new software, fixing bugs, and making sure everything runs smoothly.
                    </p>
                </div>
                <img src="images/developmentskills.png" class="developmentskills-img" />
            </div>
        </div>
    </section>
    <section class="quiz-section">
        <div class="quiz-container">
            <div id="content-recommendation">
                <h1>Want to find what's right for you?</h1>
                <p>Our <b>Krits AI</b> here to recommend you based on these 3 questions</p>
            </div>
            <div class="question" id="question1">
                <h2>What do you want to learn about?</h2>
                <button onclick='selectAnswer(1,"Web Development")'>Web Development</button> <button onclick='selectAnswer(1,"Data Science")'>Data Science</button>
                <button onclick='selectAnswer(1,"Computer Science")'>Computer Science</button> <button onclick='selectAnswer(1,"Artificial Intelligence")'>Artificial Intelligence</button>
                <button onclick='selectAnswer(1,"Machine Learning")'>Machine Learning</button> <button onclick='selectAnswer(1,"Game Development")'>Game Development</button>
                <button onclick='selectAnswer(1,"App Development")'>App Development</button>
            </div>
            <div class="question" id="question2" style="display: none;">
                <h2>What do you want to achieve?</h2>
                <button onclick='selectAnswer(2,"For careers")'>For careers</button> <button onclick='selectAnswer(2,"For Learning Skills")'>For Learning Skills</button>
                <button onclick='selectAnswer(2,"Learn for colleges")'>Learn for colleges</button> <button onclick='selectAnswer(2,"For Building Projects")'>For Building Projects</button>
            </div>
            <div class="question" id="question3" style="display: none;">
                <h2>What is your current skill level?</h2>
                <button onclick='selectAnswer(3,"Beginner")'>Beginner</button> <button onclick='selectAnswer(3,"Intermediate")'>Intermediate</button> <button onclick='selectAnswer(3,"Advanced")'>Advanced</button>
            </div>
            <div class="recommendation" id="recommendation" style="display: none;">
                <h2>Recommendations for you :</h2>
                <p id="recommendationText"></p>
            </div>
        </div>
        <img src="images/recom-img.png" style="height: 400px;" />
    </section>
    <div class="main-container-3">
        <div class="chatbot-container">
            <div class="chatbot-image-container"><img src="images/Untitled design (4).png" class="chatbot-image" alt="Cybertron AI Image" /></div>
            <div class="inf-chatbot">
                <h2 class="inf-chatbot-1">Meet our</h2>
                <h1 class="ai-name">Krits AI</h1>
                <p class="inf-chatbot-2">Our AI is here to guide you through your entire programming journey.</p>
            </div>
        </div>
        <h1 class="text-03">Begin your programming journey!</h1>
    </div>
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
    <script src="main-interface.js"></script>
</html>
