function reloadPage(url, element, elementReplace) {
    $.get(url, function (data) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, 'text/html');

        if (Array.isArray(element)) {
            element.forEach((el, index) => {
                const foundElement = doc.querySelector(el);
                if (!foundElement) {
                    console.warn(`Element ${el} not found in loaded content`);
                    return;
                }
                const newContent = foundElement.innerHTML || '';

                const replaceEl = Array.isArray(elementReplace) ? elementReplace[index] : elementReplace;
                if (replaceEl) {
                    const targetElement = document.querySelector(replaceEl);
                    if (!targetElement) {
                        console.warn(`Target element ${replaceEl} not found in document`);
                        return;
                    }
                    targetElement.innerHTML = newContent;
                }
            });
        } else {
            const foundElement = doc.querySelector(element);
            if (!foundElement) {
                console.warn(`Element ${element} not found in loaded content`);
                return;
            }
            const newContent = foundElement.innerHTML || '';
            
            if (elementReplace) {
                const targetElement = document.querySelector(elementReplace);
                if (!targetElement) {
                    console.warn(`Target element ${elementReplace} not found in document`);
                    return;
                }
                targetElement.innerHTML = newContent;
            }
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Failed to load URL:', url, textStatus, errorThrown);
    });
}