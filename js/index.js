function feedback()
{
    document.getElementById("feedback").style.display = "block";
    document.getElementById("home").style.display = "none";
    document.getElementById("about").style.display = "none";
    document.getElementById("services").style.display = "none";
    document.getElementById("contact").style.display = "none";
}
document.addEventListener("DOMContentLoaded", () => {
    const sections = [
        {
            title: "MISSION",
            content:
                "To provide exceptional services that exceed customer expectations, fostering trust and reliability in every interaction while empowering our community through innovation and commitment.",
        },
        {
            title: "VISION",
            content:
                "To be the leading service provider in our industry, renowned for our dedication to quality, sustainability, and a customer-first approach, shaping a brighter future for all stakeholders.",
        },
        {
            title: "CORE VALUES",
            content: `
                <ul class="list-unstyled">
                    <li class="p-1"><span class="text-danger">Integrity:</span> Upholding honesty and strong moral principles.</li>
                    <li class="p-1"><span class="text-danger">Excellence:</span> Striving for the highest quality in everything we do.</li>
                    <li class="p-1"><span class="text-danger">Innovation:</span> Embracing creativity to drive growth and improvement.</li>
                    <li class="p-1"><span class="text-danger">Customer</span> Focus: Prioritizing customer satisfaction and needs.</li>
                    <li class="p-1"><span class="text-danger">Teamwork:</span> Collaborating to achieve shared goals.</li>
                </ul>
            `,
        },
    ];

    let currentIndex = 0;
    const dynamicContent = document.getElementById("dynamic-content");

    const updateContent = () => {
        const { title, content } = sections[currentIndex];
        dynamicContent.innerHTML = `
            <h1 class="text-center">${title}</h1>
            <h3 class="text-center">${content}</h3>
        `;
        currentIndex = (currentIndex + 1) % sections.length;
    };

    updateContent();

    setInterval(updateContent, 3000);
});
