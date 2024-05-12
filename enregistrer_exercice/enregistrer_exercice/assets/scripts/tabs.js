const tabs = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab-content');

tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => {
        tabs.forEach(tab => tab.classList.remove('active'));
        tab.classList.add('active');

    tabContents.forEach(tabContent => tabContent.classList.remove('active-tab-content'));
        tabContents[index].classList.add('active-tab-content'); });
});