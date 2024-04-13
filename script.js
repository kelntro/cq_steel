const form = document.querySelector('form');
const fullname = document.getElementById("name");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const subject = document.getElementById("subject");
const mess = document.getElementById("message");

function sendEmail() {
   const bodyMessage = `Full Name: ${fullname.value}<br> Email: ${email.value}<br> Phone Number: ${phone.value}<br>
   Subject: ${subject.value}<br> Message: ${mess.value}<br>`;
   Email.send({
      SecureToken : "fc575573-ce99-4f15-b2f9-bc0b02ce2368",
      To: 'diosdadoramos6@gmail.com',
      From: "diosdadoramos6@gmail.com",
      Subject: subject.value,
      Body: bodyMessage
   }).then(
      message => {
         if (message == "OK") {
            Swal.fire({
               title: "Success!",
               text: "Your message has been sent!",
               icon: "success"
            });
         }
      }
   );
}

function checkInputs() {
   const items = document.querySelectorAll(".item");

   for (const item of items) {
      if (item.value == "") {
         item.classList.add("error");
         item.parentElement.classList.add("error");
      }

      if (item === phone) {
         checkPhone();
      }

      if(items[1].value != "") {
         checkEmail();
      }

      items[1].addEventListener("keyup", () => {
         if(items[1].value != "") {
            checkEmail();
         } else {
            if (item === phone) {
               checkPhone();
            }
         }
      })

      item.addEventListener("keyup", () => {
         if (item.value != "") {
            item.classList.remove("error");
            item.parentElement.classList.remove("error");
         } else {
            item.classList.add("error");
            item.parentElement.classList.add("error");
         }
      })
   }
}

function checkEmail(){
   const emailRegex = /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,3})(\.[a-z]{2,3})?$/
   ;
   const errorTxtEmail = document.querySelector(".error-txt.email");


   if(!email.value.match(emailRegex)) {
      email.classList.add("error");
      email.parentElement.classList.add("error");
      
      if(email.value != ""){
         errorTxtEmail.innerText = "Enter a valid email address";
      } else {
         errorTxtEmail.innerText = "Email address can't be blank";
      }


   } else {
      email.classList.remove("error");
      email.parentElement.classList.remove("error");
   }
}

function checkPhone() {
   const phoneRegex = /^\d+$/;
   const errorTxtPhone = document.querySelector(".error-txt.phone");

   if (!phone.value.match(phoneRegex)) {
      phone.classList.add("error");
      phone.parentElement.classList.add("error");

      if (phone.value != "") {
         errorTxtPhone.innerText = "Enter a valid phone number";
      } else {
         errorTxtPhone.innerText = "Phone number can't be blank";
      }
   } else {
      phone.classList.remove("error");
      phone.parentElement.classList.remove("error");
   }
}

form.addEventListener("submit", (e) => {
   e.preventDefault();
   checkInputs();

   if(!fullname.classList.contains("error") && !email.classList.contains("error") && 
   !phone.classList.contains("error") && !subject.classList.contains("error") && 
   !mess.classList.contains("error")) {
      sendEmail();

      form.reset();
      return false;
   }
}); 