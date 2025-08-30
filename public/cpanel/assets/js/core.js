function reloadPage(url, element, elementReplace) {
    $.get(url, function (data) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, 'text/html');

        if (Array.isArray(element)) {
            element.forEach((el, index) => {
                const newContent = doc.querySelector(el).innerHTML;

                const replaceEl = Array.isArray(elementReplace) ? elementReplace[index] : elementReplace;
                if (replaceEl) {
                    document.querySelector(replaceEl).innerHTML = newContent;
                }
            });
        } else {
            const newContent = doc.querySelector(element).innerHTML;
            if (elementReplace) {
                document.querySelector(elementReplace).innerHTML = newContent;
            }
        }
    });
}