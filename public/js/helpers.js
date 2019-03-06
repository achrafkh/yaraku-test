function downloadURI(uri, name) 
{
    var link = document.createElement("a");
    link.href = uri;
    link.click();
    link.remove();
}

String.prototype.capitalize = function() {
  return this.charAt(0).toUpperCase() + this.slice(1)
}