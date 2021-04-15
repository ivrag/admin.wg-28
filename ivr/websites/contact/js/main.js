const spinner = document.getElementById("spinner");
const loadProg = document.querySelector(".load-progress");
const mainContent = document.getElementById("main-content");
const cardBody = document.getElementById("main-card-body");

const prevDiv = document.getElementById("prev-div");
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
                },
                inlineToolbar: true
            },
            underline: Underline,
            table: Table,
            raw: RawTool,
            marker: Marker,
            list: {
              class: NestedList,
              inlineToolbar: true
            },
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: re.img_url
                    }
                },
                inlineToolbar: true
            }
        },
        i18n: {
            /**
             * @type {I18nDictionary}
             */
            messages: {
              /**
               * Other below: translation of different UI components of the editor.js core
               */
              ui: {
                "blockTunes": {
                  "toggler": {
                    "Click to tune": "klicken zum bearbeiten",
                    "or drag to move": "oder ziehen zum verschieben"
                  },
                },
                "inlineToolbar": {
                  "converter": {
                    "Convert to": "konvertieren in"
                  }
                },
                "toolbar": {
                  "toolbox": {
                    "Add": "hinzufügen"
                  }
                }
              },
          
              /**
               * Section for translation Tool Names: both block and inline tools
               */
              toolNames: {
                "Text": "Text",
                "Heading": "Titel",
                "List": "Liste",
                "Warning": "Warnung",
                "Checklist": "Check-Liste",
                "Quote": "Zitat",
                "Code": "Code",
                "Delimiter": "Begrenzer",
                "Raw HTML": "Rohes HTML",
                "Table": "Tabelle",
                "Link": "Link",
                "Marker": "Marker",
                "Bold": "Fett",
                "Italic": "Kursiv",
                "InlineCode": "Inline-Code",
                "Underline": "unterstrichen"
              },
          
              /**
               * Section for passing translations to the external tools classes
               */
              tools: {
                /**
                 * Each subsection is the i18n dictionary that will be passed to the corresponded plugin
                 * The name of a plugin should be equal the name you specify in the 'tool' section for that plugin
                 */
                "warning": { // <-- 'Warning' tool will accept this dictionary section
                  "Title": "Titel",
                  "Message": "Info",
                },
          
                /**
                 * Link is the internal Inline Tool
                 */
                "link": {
                  "Add a link": "Link hinzufügen"
                },
                /**
                 * The "stub" is an internal block tool, used to fit blocks that does not have the corresponded plugin
                 */
                "stub": {
                  'The block can not be displayed correctly.': 'Der Block kann nicht richtig angezeigt werden.'
                }
              },
          
              /**
               * Section allows to translate Block Tunes
               */
              blockTunes: {
                /**
                 * Each subsection is the i18n dictionary that will be passed to the corresponded Block Tune plugin
                 * The name of a plugin should be equal the name you specify in the 'tunes' section for that plugin
                 *
                 * Also, there are few internal block tunes: "delete", "moveUp" and "moveDown"
                 */
                "delete": {
                  "Delete": "löschen"
                },
                "moveUp": {
                  "Move up": "nach oben"
                },
                "moveDown": {
                  "Move down": "nach unten"
                }
              }
            }
        },
        onReady: () => {
            $(spinner).fadeOut().next($(mainContent).fadeIn());
        },
        onChange: () => {
            $(prevDiv).fadeOut();
        },
        data: re.contents
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
                if (re.success === 1) {
                  successAlert({
                    title: "Erfolgreich!",
                    message: "Die Daten wurden erfolgreich gespeichert!"
                  });
                  $(prevDiv).show();
                } else {
                  warningAlert({
                    title: "Speichern fehlgeschlagen",
                    message: "Beim Speichern ist ein unbekannter Fehler aufgetreten..."
                  });
                }
            }, data);
        }).catch((error) => {
            warningAlert({
                title: "Speichern fehlgeschlagen",
                message: "Die daten konnten nicht gespeichert werden! error: " + error
            });
        });
    }, false);
}, p => {
  if (p < 100) {
    loadProg.style.width = p + "%";
  } else {
    $(loadProg).fadeOut(() => {
      loadProg.style.width = "0%";
    });
  }
});