let answers = {};
function selectAnswer(e, n) {
    (answers[e] = n),
        1 === e
            ? ((document.getElementById("question1").style.display = "none"), (document.getElementById("question2").style.display = "block"))
            : 2 === e
            ? ((document.getElementById("question2").style.display = "none"), (document.getElementById("question3").style.display = "block"))
            : 3 === e && ((document.getElementById("question3").style.display = "none"), (document.getElementById("recommendation").style.display = "block"), showRecommendation());
}
function showRecommendation() {
    let e = "";
    const n = answers[1],
        t = (answers[2], answers[3]);
    "Web Development" === n
        ? "Beginner" === t
            ? (e += "Start with learning HTML and CSS. Once you are comfortable, dive into JavaScript. For tools, try CodePen for HTML/CSS and browser Developer Tools for JavaScript.\n")
            : "Intermediate" === t
            ? (e += "Consider learning a front-end framework like React or Vue.js. You can also explore backend development with Node.js.\n")
            : "Advanced" === t && (e += "Explore full-stack development with advanced frameworks like Next.js or Nuxt.js. Consider mastering tools like Webpack and Babel.\n")
        : "Data Science" === n
        ? "Beginner" === t
            ? (e += "Start with Python and libraries like Pandas and NumPy. Use Jupyter Notebook for practice and exploration.\n")
            : "Intermediate" === t
            ? (e += "Explore machine learning with scikit-learn and TensorFlow. Use platforms like Google Colab for more extensive projects.\n")
            : "Advanced" === t && (e += "Dive into deep learning with PyTorch and advanced data manipulation. Consider using cloud platforms like AWS or Azure for big data processing.\n")
        : "Computer Science" === n
        ? "Beginner" === t
            ? (e += "Focus on fundamental concepts with languages like Python or Java. Try using IDEs like PyCharm or IntelliJ IDEA.\n")
            : "Intermediate" === t
            ? (e += "Explore data structures and algorithms. Consider languages like C++ or Java, and tools like LeetCode for practice.\n")
            : "Advanced" === t && (e += "Study system design and advanced algorithms. Work with tools like Git for version control and Docker for containerization.\n")
        : "Artificial Intelligence" === n
        ? "Beginner" === t
            ? (e += "Start with Python and libraries like TensorFlow. Explore online courses on platforms like Coursera or edX.\n")
            : "Intermediate" === t
            ? (e += "Work on AI projects involving neural networks. Explore frameworks like Keras and advanced concepts in NLP and computer vision.\n")
            : "Advanced" === t && (e += "Research cutting-edge AI techniques and consider contributing to open-source AI projects. Explore advanced topics like reinforcement learning.\n")
        : "Machine Learning" === n
        ? "Beginner" === t
            ? (e += "Begin with Python and machine learning libraries like scikit-learn. Practice with Kaggle datasets.\n")
            : "Intermediate" === t
            ? (e += "Delve into deep learning with TensorFlow and PyTorch. Explore different models and techniques for real-world applications.\n")
            : "Advanced" === t && (e += "Focus on specialized areas like generative adversarial networks (GANs) or advanced ensemble methods. Work on high-impact research or projects.\n")
        : "Game Development" === n
        ? "Beginner" === t
            ? (e += "Start with learning the basics of a game engine like Unity or Unreal Engine. Try simple projects to understand game mechanics.\n")
            : "Intermediate" === t
            ? (e += "Explore more complex game development aspects like AI for games and advanced graphics. Consider using assets and libraries to enhance your projects.\n")
            : "Advanced" === t && (e += "Work on advanced game design, including multiplayer functionality and complex game physics. Consider contributing to or starting a game development community.\n")
        : "App Development" === n &&
          ("Beginner" === t
              ? (e += "Start with learning the basics of mobile development with Swift for iOS or Kotlin for Android. Use Xcode or Android Studio for development.\n")
              : "Intermediate" === t
              ? (e += "Explore cross-platform development with frameworks like Flutter or React Native. Focus on building and optimizing real-world applications.\n")
              : "Advanced" === t && (e += "Delve into advanced app features like AR/VR or complex integrations. Consider publishing and managing apps in app stores.\n")),
        (document.getElementById("recommendationText").innerText = e);
}
function toggleMenu() {
    document.querySelector(".navbar ul").classList.toggle("active");
}
function startedcompiler() {
    window.location.href = "https://www.cybertron7.in/Login/pythoninterface.awc";
}
function Krits() {
    alert("Krits AI is in Developing Stage.");
}
document.addEventListener("DOMContentLoaded", () => {
    const e = document.querySelectorAll(".animated"),
        n = new IntersectionObserver(
            (e) => {
                e.forEach((e) => {
                    e.isIntersecting && (e.target.classList.contains("animated-visible") || (e.target.classList.remove("animated-visible"), e.target.offsetWidth, e.target.classList.add("animated-visible")));
                });
            },
            { threshold: 0.2 }
        );
    e.forEach((e) => {
        n.observe(e);
    });
}),
    document.addEventListener("DOMContentLoaded", () => {
        const e = document.querySelectorAll(".animated"),
            n = new IntersectionObserver(
                (e) => {
                    e.forEach((e) => {
                        e.isIntersecting && (e.target.classList.contains("animated-visible") || (e.target.classList.remove("animated-visible"), e.target.offsetWidth, e.target.classList.add("animated-visible")));
                    });
                },
                { threshold: 0.4 }
            );
        e.forEach((e) => {
            n.observe(e);
        });
    });
const heading = document.getElementById("heading");
heading.addEventListener("click", () => {
    window.location.href = "https://cybertron7.in/";
});
const java = document.getElementById("java-id-1");
java.addEventListener("click", () => {
    window.alert("This course will be start soon buddies!!!");
});
const js = document.getElementById("js-id-1");
js.addEventListener("click", () => {
    window.alert("This course will be start soon buddies!!!");
});
