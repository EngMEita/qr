document.addEventListener("DOMContentLoaded", () => {
    const qrCanvas = document.getElementById("qrCanvas");
    const qrWrapper = document.getElementById("qrWrapper");
    const placeholder = document.getElementById("placeholderText");
    const form = document.getElementById("qrForm");
    const typeSelect = document.getElementById("type");
    const dataInput = document.getElementById("data");
    const dataLabel = document.querySelector("label[for='data']");
    const sizeInput = document.getElementById("size");
    const sizeValue = document.getElementById("sizeValue");
    const logoInput = document.getElementById("logoInput");
    const logoStatus = document.getElementById("logoStatus");
    const resetLogoButton = document.getElementById("resetLogo");
    const enableLogoSwitch = document.getElementById("enableLogo");
    const detectLocationButton = document.getElementById("detectLocation");
    const copyPayloadButton = document.getElementById("copyPayload");
    const downloadPngButton = document.getElementById("downloadPng");
    const downloadSvgButton = document.getElementById("downloadSvg");
    const colorInput = document.getElementById("color");
    const bgColorInput = document.getElementById("bgColor");
    const eccSelect = document.getElementById("ecc");
    const marginInput = document.getElementById("margin");
    const marginValue = document.getElementById("marginValue");
    const dotsTypeSelect = document.getElementById("dotsType");
    const cornerSquareSelect = document.getElementById("cornerSquare");
    const cornerDotSelect = document.getElementById("cornerDot");

    let lastPayload = "";
    let logoSource = "assets/default-logo.svg";
    let logoEnabled = true;
    let logoLabel = "يستخدم الشعار الافتراضي";
    marginValue.textContent = `${marginInput.value}px`;

    const qrCode = new QRCodeStyling({
        width: Number(sizeInput.value),
        height: Number(sizeInput.value),
        data: "https://example.com",
        margin: Number(marginInput.value),
        type: "svg",
        qrOptions: {
            errorCorrectionLevel: eccSelect.value
        },
        image: logoSource,
        imageOptions: {
            crossOrigin: "anonymous",
            margin: 4
        },
        dotsOptions: {
            color: colorInput.value,
            type: dotsTypeSelect.value
        },
        cornersSquareOptions: {
            type: cornerSquareSelect.value
        },
        cornersDotOptions: {
            type: cornerDotSelect.value
        },
        backgroundOptions: {
            color: bgColorInput.value
        }
    });

    qrCode.append(qrCanvas);

    const dataHints = {
        url: {
            label: "رابط الموقع | Website URL",
            placeholder: "https://example.com"
        },
        text: {
            label: "النص | Text",
            placeholder: "اكتب النص هنا"
        }
    };

    const updatePrimaryDataHint = () => {
        if (!dataInput || !dataLabel) {
            return;
        }
        const hints = dataHints[typeSelect.value];
        if (!hints) {
            return;
        }
        dataLabel.textContent = hints.label;
        dataInput.placeholder = hints.placeholder;
        dataInput.type = typeSelect.value === "url" ? "url" : "text";
        dataInput.inputMode = typeSelect.value === "url" ? "url" : "text";
    };

    const groups = document.querySelectorAll(".data-group");
    const toggleGroups = () => {
        const current = typeSelect.value;
        groups.forEach(group => {
            const allowed = group.dataset.group ? group.dataset.group.trim().split(/\s+/) : [];
            const isActive = allowed.includes(current);
            group.classList.toggle("d-none", !isActive);
            const inputs = group.querySelectorAll("input, textarea");
            inputs.forEach(input => {
                const shouldRequire = input.dataset.required === "true" && isActive;
                input.required = shouldRequire;
                input.disabled = !isActive;
                if (!isActive) {
                    input.value = input.defaultValue;
                }
            });
        });
    };

    const ensureProtocol = (value) => {
        if (!value) return "";
        if (/^https?:\/\//i.test(value)) {
            return value.trim();
        }
        return `https://${value.trim()}`;
    };

    const buildPayload = () => {
        const type = typeSelect.value;
        switch (type) {
            case "url":
                return ensureProtocol(form.data.value);
            case "text":
                return form.data.value.trim();
            case "phone":
                return form.phone.value ? `tel:${form.phone.value.trim()}` : "";
            case "sms": {
                const phone = form.phone.value.trim();
                const body = encodeURIComponent(form.smsBody.value.trim());
                return phone ? `sms:${phone}?body=${body}` : "";
            }
            case "whatsapp": {
                const phone = form.phone.value.trim().replace(/[^\d+]/g, "");
                const msg = encodeURIComponent(form.waMessage.value.trim());
                return phone ? `https://wa.me/${phone}?text=${msg}` : "";
            }
            case "email": {
                const to = form.emailAddress.value.trim();
                const subject = encodeURIComponent(form.emailSubject.value.trim());
                const body = encodeURIComponent(form.emailBody.value.trim());
                const query = [];
                if (subject) query.push(`subject=${subject}`);
                if (body) query.push(`body=${body}`);
                const queryString = query.length ? `?${query.join("&")}` : "";
                return to ? `mailto:${to}${queryString}` : "";
            }
            case "location": {
                const lat = form.latitude.value.trim();
                const lng = form.longitude.value.trim();
                return lat && lng ? `geo:${lat},${lng}` : "";
            }
            case "contact": {
                const fullName = form.fullName.value.trim();
                const parts = fullName.split(" ");
                const lastName = parts.length > 1 ? parts.slice(1).join(" ") : "";
                const firstName = parts[0] || "";
                const phone = form.contactPhone.value.trim();
                const email = form.contactEmail.value.trim();
                const org = form.org.value.trim();
                const title = form.title.value.trim();
                const website = ensureProtocol(form.website.value.trim());
                const address = form.address.value.trim();
                const note = form.note.value.trim();

                const vcard = [
                    "BEGIN:VCARD",
                    "VERSION:3.0",
                    `N:${lastName};${firstName};;;`,
                    `FN:${fullName}`,
                    phone ? `TEL;TYPE=CELL:${phone}` : "",
                    email ? `EMAIL;TYPE=INTERNET:${email}` : "",
                    org ? `ORG:${org}` : "",
                    title ? `TITLE:${title}` : "",
                    website ? `URL:${website}` : "",
                    address ? `ADR;TYPE=WORK:;;${address};;;;` : "",
                    note ? `NOTE:${note}` : "",
                    "END:VCARD"
                ].filter(Boolean).join("\n");
                return vcard;
            }
            default:
                return "";
        }
    };

    const refreshQr = () => {
        const payload = buildPayload();
        if (!payload) {
            placeholder.textContent = "أدخل البيانات المطلوبة أولاً";
            qrWrapper.classList.remove("has-qr");
            lastPayload = "";
            return;
        }
        lastPayload = payload;
        qrCode.update({
            data: payload,
            width: Number(sizeInput.value),
            height: Number(sizeInput.value),
            image: logoEnabled ? logoSource : null,
            margin: Number(marginInput.value),
            qrOptions: {
                errorCorrectionLevel: eccSelect.value
            },
            dotsOptions: {
                color: colorInput.value,
                type: dotsTypeSelect.value
            },
            cornersSquareOptions: {
                type: cornerSquareSelect.value
            },
            cornersDotOptions: {
                type: cornerDotSelect.value
            },
            backgroundOptions: {
                color: bgColorInput.value
            }
        });
        qrWrapper.classList.add("has-qr");
        placeholder.textContent = "تم إنشاء الكود، يمكنك تحميله أو طباعته.";
    };

    const dataInputs = form.querySelectorAll(".data-group input, .data-group textarea");
    dataInputs.forEach((input) => {
        input.addEventListener("input", refreshQr);
        input.addEventListener("change", refreshQr);
    });

    typeSelect.addEventListener("change", () => {
        toggleGroups();
        updatePrimaryDataHint();
        refreshQr();
    });

    sizeInput.addEventListener("input", () => {
        sizeValue.textContent = `${sizeInput.value}px`;
        refreshQr();
    });

    marginInput.addEventListener("input", () => {
        marginValue.textContent = `${marginInput.value}px`;
        refreshQr();
    });

    colorInput.addEventListener("input", refreshQr);
    bgColorInput.addEventListener("input", refreshQr);
    eccSelect.addEventListener("change", refreshQr);
    dotsTypeSelect.addEventListener("change", refreshQr);
    cornerSquareSelect.addEventListener("change", refreshQr);
    cornerDotSelect.addEventListener("change", refreshQr);

    form.addEventListener("submit", (event) => {
        event.preventDefault();
        refreshQr();
    });

    form.addEventListener("reset", () => {
        setTimeout(() => {
            typeSelect.value = "url";
            logoSource = "assets/default-logo.svg";
            logoEnabled = true;
            logoLabel = "يستخدم الشعار الافتراضي";
            enableLogoSwitch.checked = true;
            logoStatus.textContent = logoLabel;
            sizeValue.textContent = `${sizeInput.value}px`;
            marginValue.textContent = `${marginInput.value}px`;
            toggleGroups();
            updatePrimaryDataHint();
            refreshQr();
        }, 0);
    });

    const readLogo = (file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            logoSource = e.target.result;
            logoLabel = `شعار مخصص: ${file.name}`;
            logoStatus.textContent = logoLabel;
            refreshQr();
        };
        reader.readAsDataURL(file);
    };

    logoInput.addEventListener("change", (event) => {
        const [file] = event.target.files;
        if (file) {
            const validTypes = ["image/png", "image/svg+xml"];
            if (!validTypes.includes(file.type)) {
                alert("الرجاء اختيار ملف PNG أو SVG صالح.");
                event.target.value = "";
                return;
            }
            readLogo(file);
        }
    });

    resetLogoButton.addEventListener("click", () => {
        logoSource = "assets/default-logo.svg";
        logoInput.value = "";
        logoLabel = "يستخدم الشعار الافتراضي";
        logoStatus.textContent = logoLabel;
        refreshQr();
    });

    enableLogoSwitch.addEventListener("change", () => {
        logoEnabled = enableLogoSwitch.checked;
        if (!logoEnabled) {
            logoStatus.textContent = "تم تعطيل الشعار | Logo disabled";
        } else {
            const isDefault = logoSource.includes("default-logo");
            logoLabel = isDefault ? "يستخدم الشعار الافتراضي" : logoLabel;
            logoStatus.textContent = logoLabel;
        }
        refreshQr();
    });

    detectLocationButton?.addEventListener("click", async () => {
        if (!navigator.geolocation) {
            alert("المتصفح لا يدعم تحديد الموقع.");
            return;
        }
        detectLocationButton.disabled = true;
        detectLocationButton.textContent = "جارِ تحديد الموقع...";
        navigator.geolocation.getCurrentPosition(
            (position) => {
                form.latitude.value = position.coords.latitude.toFixed(6);
                form.longitude.value = position.coords.longitude.toFixed(6);
                detectLocationButton.disabled = false;
                detectLocationButton.textContent = "استخدام موقعي الحالي";
                refreshQr();
            },
            () => {
                alert("تعذر جلب الموقع. يرجى السماح للصلاحيات.");
                detectLocationButton.disabled = false;
                detectLocationButton.textContent = "استخدام موقعي الحالي";
            }
        );
    });

    copyPayloadButton.addEventListener("click", async () => {
        if (!lastPayload) {
            refreshQr();
        }
        if (!lastPayload) {
            alert("لا يوجد محتوى لنسخه بعد.");
            return;
        }
        try {
            await navigator.clipboard.writeText(lastPayload);
            copyPayloadButton.textContent = "تم النسخ ✓";
            setTimeout(() => (copyPayloadButton.textContent = "نسخ البيانات"), 1400);
        } catch (_) {
            alert("تعذر النسخ التلقائي، انسخ المحتوى يدوياً.");
        }
    });

    downloadPngButton.addEventListener("click", () => {
        if (!lastPayload) {
            refreshQr();
        }
        qrCode.download({ name: "qr-code", extension: "png" });
    });

    downloadSvgButton.addEventListener("click", () => {
        if (!lastPayload) {
            refreshQr();
        }
        qrCode.download({ name: "qr-code", extension: "svg" });
    });

    toggleGroups();
    updatePrimaryDataHint();
    refreshQr();
});
