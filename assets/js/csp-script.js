const input = document.getElementById("service_icon");
const btn = document.getElementById("service_icon_btn");
const preview = document.getElementById("service_icon_preview");

const mediaFrame = wp.media({
  title: "Select a Service Icon",
  button: {
    text: "Use this Icon",
  },
  multiple: false,
});

btn.addEventListener("click", function (e) {
  e.preventDefault();
  mediaFrame.open();
});

mediaFrame.on("select", () => {
  const attachment = mediaFrame.state().get("selection").first().toJSON();
  input.value = attachment.id;
  preview.src = attachment.url;
});
