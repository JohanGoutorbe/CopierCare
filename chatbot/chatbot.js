function start() {

    let res_msg = document.createElement('div');
    res_msg.innerHTML = "Hello myself CopierCare's ChatBot, How can I help you ?":
    res_msg.setAttribute("class","left")
}

document.getElementById('send').addEventlistener("click", async (e) => {
    e.preventDefault();
});