function openSidebar() {

    const sidebar =
        document.getElementById("sidebar");

    const overlay =
        document.getElementById("sidebarOverlay");

    sidebar?.classList.add("active");
    overlay?.classList.add("active");

}


function closeSidebar() {

    const sidebar =
        document.getElementById("sidebar");

    const overlay =
        document.getElementById("sidebarOverlay");

    sidebar?.classList.remove("active");
    overlay?.classList.remove("active");

}