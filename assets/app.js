/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

require("bootstrap");
const $ = require("jquery");
const MAX_NUMBER = 5000000;
$(function () {
  const form = $("form");
  document
    .querySelectorAll("#brands-input .form-check-input")
    .forEach((element) => (element.checked = false));
  document
    .querySelectorAll("#energies-input .form-check-input")
    .forEach((element) => (element.checked = false));
  let checked_brands = [],
    checked_models = [],
    min_year = 0,
    max_year = new Date().getFullYear(),
    checked_energy = [],
    gearbox = [],
    min_price = 0,
    max_price = MAX_NUMBER;

  // console.log("tableChecked= ", checked_brands);
  $("#brands-input .form-check-input").on("change", (e) => {
    checked_brands = verifyIfChecked(e.currentTarget, checked_brands);
    // console.log(checked_brands);
    // console.log(
    //   checked_brands,
    //   checked_brands
    //     .join(",")
    //     .replaceAll(/[^0-9,]/gi, "")
    //     .split(",")
    // );
  });
  $("#brands-dropdown").on("hide.bs.dropdown", function (e) {
    if (checked_brands.length > 0) {
      // console.log(checked_brands);
      fetch(form.attr("action"), {
        method: form.attr("method"),
        body: checked_brands,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          charset: "utf-8",
        },
      })
        .then((response) => response.text())
        .then((html) => {
          let content = document.createElement("html");
          content.innerHTML = html;
          // console.log(html);
          let newFilter = content.querySelector("#models-input");
          // let newFilter = content.querySelector("#filter_models");
          // console.log(newFilter.innerHTML);
          // $("#filter_models").html("newFilter.innerHTML");
          // $("#filter_models").html(newFilter.innerHTML);
          // console.log(
          //   "Document " + document.querySelector("#filter_models").innerHTML
          // );
          // document.querySelector("#models-input").replaceWith(newFilter);
          $("#models-input").html(newFilter.innerHTML);
        })
        .catch((error) => console.log(error));
    }
  });
  $("#models-input").on("change", (e) => {
    if (e.target.className == "form-check-input") {
      checked_models = verifyIfChecked(e.target, checked_models);
      // console.log(
      //   checked_models,
      //   checked_models
      //     .join(",")
      //     .replaceAll(/[^0-9,]/gi, "")
      //     .split(",")
      // );
    }
  });
  $("#filter_energy .form-check-input").on("change", (e) => {
    checked_energy = verifyIfChecked(e.currentTarget, checked_energy);
    // console.log(
    //   checked_energy,
    //   checked_energy.map((element) =>
    //     element.replaceAll(/(\w*\d*\W*)+=+/gi, "")
    //   )
    // );
  });
  $("#filter_gearbox .form-check-input").on("change", (e) => {
    gearbox[0] =
      e.currentTarget.getAttribute("name") + "=" + e.currentTarget.value;
    // console.log(
    //   gearbox,
    //   gearbox
    //     .join(",")
    //     .replaceAll(/(\w*\d*\W*)+=/gi, "")
    //     .split(",")
    // );
  });
  $("#filter_minYear").on("blur", (e) => {
    min_year = parseInt(e.currentTarget.value);
  });
  $("#filter_maxYear").on("blur", (e) => {
    max_year = parseInt(e.currentTarget.value);
    // console.log(e.currentTarget.value);
  });
  $("#filter_minPrice").on("blur", (e) => {
    min_price = parseInt(e.currentTarget.value);
    // console.log(e.currentTarget.value);
  });
  $("#filter_maxPrice").on("blur", (e) => {
    max_price = parseInt(e.currentTarget.value);
    // console.log(e.currentTarget.value);
  });
  form.on("submit", async (e) => {
    e.preventDefault();
    let formData = {
      brands: checked_brands
        .join(",")
        .replaceAll(/[^0-9,]/gi, "")
        .split(","),
      models: checked_models
        .join(",")
        .replaceAll(/[^0-9,]/gi, "")
        .split(","),
      gearbox: gearbox
        .join(",")
        .replaceAll(/(\w*\d*\W*)+=/gi, "")
        .split(","),
      energy: checked_energy.map((element) =>
        element.replaceAll(/(\w*\d*\W*)+=+/gi, "")
      ),
      minYear: min_year,
      maxYear: max_year,
      minPrice: min_price,
      maxPrice: max_price,
    };
    let filteredPaged = await filter(formData);
    updatePage(filteredPaged);
  });
  function updatePage(filteredPaged) {
    const html = document.createElement("html");
    html.innerHTML = filteredPaged;
    // console.log(filteredPaged);
    $("#cars-container").html(html.querySelector("#cars-container").innerHTML);
  }
  async function filter(formData) {
    // body = JSON.stringify({
    //   brands: ["16"],
    //   models: [""],
    //   gearbox: ["Automatique"],
    //   energy: ["Essence", "Diesel", "Electrique"],
    //   minYear: 200,
    //   maxYear: 30000,
    //   minPrice: 100,
    //   maxPrice: 1000009,
    // }) /**Test example */
    let body = JSON.stringify({ formData });
    console.log(body);
    const init = {
      method: "POST",
      body: body,
    };
    return fetch("/car/", init)
      .then((response) => {
        return response.text();
      })
      .catch((error) => console.log("Error: " + error));
  }

  function verifyIfChecked(element, tableChecked) {
    if (element.checked)
      tableChecked.push(element.getAttribute("name") + "=" + element.value);
    else
      tableChecked = tableChecked.filter((oldChecked) => {
        let unchecked = element.getAttribute("name").concat("=", element.value);
        return oldChecked != unchecked;
      });
    return tableChecked;
  }
});
