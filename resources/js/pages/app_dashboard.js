import axios from "axios";
import {
    getCurrentCsrfToken,
    getCurrentUrl,
    getBaseUrl,
    datatableDynamicNumberColumn,
    getDataFormInputs,
    resetFormInputs,
    parseJsonToDataAttr,
    decodeFromJsonDataAttr,
} from './../utils/func'

var Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1000 * 3,
});
toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: false,
    progressBar: false,
    positionClass: "toast-bottom-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

$(document).ready(function () {
    let suggestions = [
      "Channel",
      "CodingLab",
      "CodingNepal",
      "YouTube",
      "YouTuber",
      "YouTube Channel",
      "Blogger",
      "Bollywood",
      "Vlogger",
      "Vechiles",
      "Facebook",
      "Freelancer",
      "Facebook Page",
      "Designer",
      "Developer",
      "Web Designer",
      "Web Developer",
      "Login Form in HTML & CSS",
      "How to learn HTML & CSS",
      "How to learn JavaScript",
      "How to became Freelancer",
      "How to became Web Designer",
      "How to start Gaming Channel",
      "How to start YouTube Channel",
      "What does HTML stands for?",
      "What does CSS stands for?",
    ];

    // getting all required elements
    const searchInput = document.querySelector(".searchInput");
    const input = searchInput.querySelector("input");
    const resultBox = searchInput.querySelector(".resultBox");
    const icon = searchInput.querySelector(".icon");
    let linkTag = searchInput.querySelector("a");
    let webLink;


    function showSuggestions(list) {
      resultBox.innerHTML = list;
    }

    // if user press any key and release
    const search = async (q) => {
      let emptyArray = [];
        searchInput.classList.add("active"); //show autocomplete box
        resultBox.innerHTML = "<li>loading...</li>"
        const { data } = await axios({
          url: getBaseUrl() + '/dashboard/admin/main/violation?list=students&term=' + q,
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCurrentCsrfToken(),
            'Content-Type': 'application/json'
          },
        })
        console.log('data', data)
        if (data.length > 0) {
            // emptyArray = suggestions.filter((data) => {
            //     //filtering array value and user characters to lowercase and return only those words which are start with user enetered chars
            //     return data
            //         .toLocaleLowerCase()
            //         .startsWith(q.toLocaleLowerCase());
            // });
            emptyArray = data.map((item) => {
                // passing return data inside li tag
                return `<li><a href="${ROUTES.MASTER_DATA_STUDENT}/${item.id}">${item.name} (${item.grade.name}/${item.nisn})</a></li>`
            });
            showSuggestions(emptyArray.join(""));
            let allList = resultBox.querySelectorAll("li");
            for (let i = 0; i < allList.length; i++) {
                //adding onclick attribute in all li tag
                allList[i].setAttribute("onclick", "select(this)");
            }
        } else {
            resultBox.innerHTML = "<li>No Data Found</li>";
            // searchInput.classList.remove("active"); //hide autocomplete box
        }
    }

    const debounce = (func, wait) => {
      let timeout;

      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };

        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    };

    const onsearchinput = debounce(function (e) {
        // if arrow keys, do nothing
        if (e.keyCode === 38 || e.keyCode === 40) {
            return;
        }

        let userData = e.target.value; //user enetered data

        if (userData && userData.length > 0 && userData !== "") {
          // run debounce function
          return search(userData)
        }
        return
    }, 250)

    input.addEventListener("keyup", onsearchinput);
    // input.addEventListener("blur", () => {
    //   searchInput.classList.remove("active");
    // });
    // on all element click
    document.addEventListener("click", function (e) {
      if (e.target !== input && e.target !== resultBox && e.target !== icon && e.target !== linkTag) {
        searchInput.classList.remove("active");
      }
    });
});
