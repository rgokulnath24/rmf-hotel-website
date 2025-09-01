function openSidebar()
{
//alert("hello");
document.getElementById("sidebar").classList.add('active');
document.getElementById('harmburger').style.display='none';
document.getElementById('mainContent').classList.add('shifted');
}
function closeSidebar()
{
document.getElementById('sidebar').classList.remove('active');
document.getElementById('harmburger').style.display='block';
document.getElementById('mainContent').classList.remove('shifted');
}