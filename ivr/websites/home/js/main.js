const spinner = document.getElementById("spinner");
const mainContent = document.getElementById("main-content");
const cardBody = document.getElementById("main-card-body");

const saveBtn = document.getElementById("save-btn");

let x = new xhr();
x.get("POST", "./includes/get/", rsp => {
    let re;
    try {
        re = JSON.parse(rsp);
    } catch(err) {
        warningAlert({
            title: "#Fehler",
            message: "Fehler bei der Dateneinlesung"
        });
        $(spinner).fadeOut().next($(mainContent).fadeIn());
        cardBody.innerHTML = "#Fehler";
        return false;
    }
    const editor = new EditorJS({
        holder: "editorjs",
        tools: {
            header: {
                class: Header,
                config: {
                    placeholder: 'Titel hinzufügen',
                    levels: [1, 2, 3, 4, 5],
                    defaultLevel: 2
                }
            },
            underline: Underline,
            table: Table,
            marker: Marker,
            list: NestedList,
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: "link to backend"
                    }
                }
            }
        },
        onReady: () => {
            $(spinner).fadeOut().next($(mainContent).fadeIn());
        },
        data: re
    });
    
    saveBtn.addEventListener("click", () => {
        editor.save().then((output) => {
            let data = {
                editorData: JSON.stringify(output)
            }
            let x = new xhr();
            x.post("POST", "./includes/save/", rsp => {
                let re;
                try {
                    re = JSON.parse(rsp);
                } catch(err) {
                    warningAlert({
                        title: "Speichern fehlgeschlagen",
                        message: "Die daten konnten nicht gespeichert werden!"
                    });
                    return false;
                }
                successAlert({
                    title: "Erfolgreich!",
                    message: "Die Daten wurden erfolgreich gespeichert!"
                });
            }, data);
        }).catch((error) => {
            warningAlert({
                title: "Speichern fehlgeschlagen",
                message: "Die daten konnten nicht gespeichert werden!"
            });
        });
    }, false);
});