const teamMembers = {
    "sarthak": {
    name: "Sarthak Rajvanshi",
    role: "Full-stack Developer",
    bio: "A passionate full-stack developer and a 2nd-year BTech student (Batch 2023-27) in CSAI at GL Bajaj, Greater Noida. Skilled in C, Python, HTML, CSS, and PHP, I have independently developed the Lost Sync website, handling both frontend and backend. Constantly exploring new technologies to enhance my skills and build innovative solutions",
    img: "sarthak.jpeg",
    linkedin: "https://in.linkedin.com/in/sarthak-rajvanshi-132259352",
    github: "https://github.com/sarthak867",
    instagram: "https://www.instagram.com/_its._sarthak"
}
,
    "sarthakYadav": {
        name: "Sarthak Yadav",
        role: "Testing",
        bio: "2nd-year CSAI student (Batch 2023-27) at GL Bajaj, Greater Noida.",
        img: "sarthakyadav.jpeg",
        linkedin: "https://www.linkedin.com/in/sarthak-yadav-49aa1b1a6/",
        github: "https://github.com/SarthakYadav2911",
        instagram: "#"
    },
    "sapna": {
        name: "Sapna Sharma",
        role: "Testing",
        bio: "2nd-year CSAI student (Batch 2023-27) at GL Bajaj, Greater Noida.",
        img: "sapna.jpeg",
        linkedin: "https://www.linkedin.com/in/sapna-sharma-9516a9329",
        github: "#",
        instagram: "https://www.instagram.com/sapna_sharma0810"
    },
    "shivam": {
        name: "Shivam Kumar",
        role: "Testing",
        bio: "2nd-year CSAI student (Batch 2023-27) at GL Bajaj, Greater Noida.",
        img: "shivam.jpeg",
        linkedin: "https://www.linkedin.com/in/shivam-kumar-06250333b",
        github: "#",
        instagram: "https://www.instagram.com/shivam_78_"
    }
};

function showDetails(member) {
    const details = teamMembers[member];
    document.getElementById("detail-name").textContent = details.name;
    document.getElementById("detail-role").textContent = details.role;
    document.getElementById("detail-bio").textContent = details.bio;
    document.getElementById("detail-image").src = details.img;
    document.getElementById("linkedin").href = details.linkedin;
    document.getElementById("github").href = details.github;
    document.getElementById("instagram").href = details.instagram;

    document.getElementById("team-details").style.display = "flex";
}
