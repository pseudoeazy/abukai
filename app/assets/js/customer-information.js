const view = {
  form: document.forms["information"],
  imagePreview: document.getElementById("imagePreview"),
  response: document.getElementById("response"),
  loader: document.getElementById("loader"),

  watch() {
    this.form.picture.addEventListener("change", handleImageUpload);
    this.form.addEventListener("blur", (e) => validateInput(e.target), true);
    this.form.addEventListener("submit", handleSubmit);
  },
  createElement(tag, content, attributes) {
    const element = document.createElement(tag);
    element.textContent = content;

    for (const key in attributes) {
      element.setAttribute(key, attributes[key]);
    }
    return element;
  },
};

/**
 * Handles the form submission event.
 * Performs input validation, sends a POST request to the server, and handles the response accordingly.
 *
 * @param {Event} e - The form submission event object.
 * @returns {void}
 */
async function handleSubmit(e) {
  e.preventDefault();
  const formData = new FormData(view.form);

  try {
    view.response.innerHTML = "";
    view.loader.classList.remove("hidden");
    [...view.form.elements].forEach((element) => validateInput(element));

    const response = await fetch("index.php?route=account/register", {
      method: "POST",
      body: formData,
    });
    view.loader.classList.add("hidden");

    // show error for any status code above 2xx
    if (response.status > 299) {
      const errorData = await response.json();
      console.log({ errorData });
      throw new Error(JSON.stringify(errorData));
    } else {
      const responseData = await response.json();
      const successResponse = view.createElement(
        "span",
        responseData?.message,
        {
          class: "block text-green-400 font-semibold text-center capitalize",
        }
      );
      view.response.appendChild(successResponse);

      //clear stored images and reset form if no error occured
      localStorage.removeItem("file");
      view.imagePreview.innerHTML = "";
      view.form.reset();
    }
  } catch (e) {
    console.log({ e });
    try {
      const { errors } = JSON.parse(e.message);
      Object.values(errors).forEach((error) => {
        const response = view.createElement("span", error, {
          class: "block text-red-400 font-semibold text-center mb-1 capitalize",
        });
        view.response.appendChild(response);
      });
    } catch (e) {
      console.log(e.message);
      alert(e.message);
    }
  }
}

/**
 * Validates the input elements of a form.
 *
 * @param {HTMLElement} element - The input element to be validated.
 * @returns {void}
 */
export function validateInput(element) {
  if (element.name !== "countries" && element.name !== "picture") {
    element.classList.remove("error");
    if (!element.value.trim()) {
      element.classList.add("error");
    }
    if (element.name === "email" && !isValidEmail(element.value)) {
      element.classList.add("error");
    }
  }
}

/**
 * Checks if a given email address is valid based on a regular expression pattern.
 *
 * @param {string} email - The email address to be validated.
 * @returns {boolean} - Returns true if the email address is valid, false otherwise.
 */
export function isValidEmail(email) {
  const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return emailRegex.test(email);
}

/**
 * Converts a base64 string to a File object.
 *
 * @param {string} base64String - The base64 string to convert.
 * @returns {File} - The converted File object.
 */
function convertStringToImage(base64String) {
  // Extract MIME type and base64 data
  const matches = base64String.match(/^data:([A-Za-z-+\/]+);base64,(.+)$/);
  const mime = matches[1];
  const base64Data = matches[2];

  // Convert base64 to a Blob
  const byteCharacters = atob(base64Data);
  const byteArrays = [];
  for (let i = 0; i < byteCharacters.length; i++) {
    byteArrays.push(byteCharacters.charCodeAt(i));
  }
  const blob = new Blob([new Uint8Array(byteArrays)], { type: mime });

  // Create a File object from the Blob
  const file = new File([blob], "filename.jpg", { type: mime });

  return file;
}

/**
 * Retrieves a base64 string from the localStorage and converts it into a File object.
 *
 * @returns {File|undefined} - A File object if there is a base64 string in the localStorage, otherwise undefined.
 */
function getImage() {
  const file = localStorage.getItem("file");
  if (file) {
    return convertStringToImage(file);
  }
}

/**
 * Renders an image preview on the webpage.
 *
 * @param {HTMLElement} imagePreview - The element where the image preview will be displayed.
 * @param {File} file - The file object representing the image to be rendered.
 * @returns {void}
 */
function renderImage(imagePreview, file) {
  const reader = new FileReader();

  reader.onload = function (e) {
    localStorage.setItem("file", e.target.result);

    const img = document.createElement("img");
    img.src = e.target.result;
    img.style.maxWidth = "100%";
    img.style.maxHeight = "100%";
    imagePreview.innerHTML = "";
    imagePreview.appendChild(img);
  };
  reader.readAsDataURL(file);
}

/**
 * Handles the image upload event.
 *
 * Checks if a file has been selected by the user, and if so, it renders the image preview on the webpage.
 * If no file is selected, it retrieves the image from local storage and renders it.
 * If the retrieved image is an instance of the File object, it updates the file input with the retrieved image and renders the image preview.
 *
 * @returns {void}
 */
function handleImageUpload() {
  const { imagePreview, form } = view;
  let file = form.picture.files[0];

  if (file) {
    renderImage(imagePreview, file);
  } else {
    const image = getImage();
    if (image instanceof File) {
      // Create a new DataTransfer object
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(image);

      // Assign the DataTransfer object to the file input
      form.picture.files = dataTransfer.files;
      renderImage(imagePreview, image);
    }
  }
}

addEventListener("DOMContentLoaded", () => {
  handleImageUpload();
  view.watch();
});
