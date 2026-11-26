 import QtQuick 2.15
import QtGraphicalEffects 1.15
import QtQuick.Controls 2.15 as NewControl
import QtQuick.Layouts 1.15
import "qrc:/MyComponents"
// import "../components"

Item{
    id: homeRight
    anchors.fill: parent

    property int roirectcustom_size : roirectinner.width

    Component.onCompleted:{
        timer_focus.running = true
    }

    Connections{
        target: bg
        function onStartScan(){
            scanButton.clicked()
        }
    }

    Connections{
        target: backend
        function onGetLiveImage(result){
            // const p1 = roirectcustom.x/roirectinner.width
            // const p2 = roirectcustom.y/roirectinner.height
            // const p3 = parseInt(roirectcustom.width)/roirectinner.width
            // const p4 = parseInt(roirectcustom.width)/roirectinner.width   
            // for (var j = 0; j < 7; j++)  {
            //     backend.setSelection(j)
            //     backend.setParameter(1)
            //     backend.set_tuple(p1, 0)
            //     backend.set_tuple(p2, 1)
            //     backend.set_tuple(p3, 2)
            //     backend.set_tuple(p4, 3)
            //     backend.write_file()
            // }
            if(result){
                // imageselection.source = ""
                imageselection.source = folder+"live.jpg"
            }           
            backend.startCamera()
            timer_sleep.restart()
        }
        function onScanCompleted(){
            text1.text = ""
            text2.text = ""
            text3.editText = ""
            text4.text = ""
            text5.text = ""
        }
    }
    Connections{
        target: scanButton
        function onRefresh(){
            lot = text1.text
            sku = text2.text
            type = text3.editText
            _size = text4.text
            remarks = text5.text
        }
    }
    Connections{
        target: messageDialogOK
        function onClicked(){
            internal.enableLayout(true)
        }
    }
    QtObject{
        id: internal

        signal tableclear
        
        function roiUpdate(){
            const p1 = roirectcustom.x/roirectinner.width
            const p2 = roirectcustom.y/roirectinner.height
            const p3 = parseInt(roirectcustom.width)/roirectinner.width
            const p4 = parseInt(roirectcustom.width)/roirectinner.width
            for (var j = 0; j < 7; j++)  {
                backend.setSelection(j)
                backend.setParameter(1)
                backend.set_tuple(p1, 0)
                backend.set_tuple(p2, 1)
                backend.set_tuple(p3, 2)
                backend.set_tuple(p4, 3)
                backend.write_file()
            }
            busyLabelText = ""
            backend.stopCamera()
            backend.captureLive()
            imageselection.source = folder+"/live.jpg"
            // backend.startCamera()
            // timer_sleep.restart()
        }
        function enableLayout(access){
            gridLayoutBottom.enabled = access
            // flickable.enabled = access
            titleBar.enabled = access
            // leftMenu.enabled = access
            rightMenu.enabled = access
            btnClose.enabled = access
        }
        function capture(door){
            if(door == true){
                print("scan staretd")
                backend.stopCamera()
                timer_sleep.running = false
                // rotation = isRotateScan
                print("isRotateScan : ", isRotateScan)
                print("isrotation : ", isrotation)
                if(scanMode){
                    chat_model.submitall()
                    searchText = ""
                    print("tableclear")
                    internal.tableclear()
                    print("tableclear")
                    folderNo = chat_model.get_maxID()
                    folder_name = backend.createFolder(folderNo)
                    print("folder created")
                }else{
                    if(newScan1){
                        newScan = true
                        chat_model1.submitall()
                        searchText = ""
                        internal.tableclear()
                        folderNo = chat_model1.get_maxID()
                        folder_name = backend.createFolder(folderNo)
                    }else{
                        newScan = false
                    }
                }
                if(isRotateScan==true){
                    no_scans = image_count
                }else{
                    no_scans = 1
                }
                print("no_scans : ", no_scans)
                for (scanning_no = 1; scanning_no<=no_scans; scanning_no++) {
                    print("scanning : ", scanning_no)
                    captured = backend.setSettings(scanning_no)
                    if(captured == true){
                        
                        manualText = 0
                        manualText1 = 0
                        manualText2 = 0
                        manualText3 = 0
                        manualText4 = 0
                        if(scanMode){
                            if(isAutomark){
                                if(isRotateScan==true){
                                    if(scanning_no==1){
                                        hphtText1 = backend.get_hpht()
                                        cvdText1 = backend.get_cvd()
                                        rftText1 = backend.get_rft()
                                        allText1 = backend.get_all()
                                        cvd_tText1 = backend.get_cvd_t()
                                    }else if(scanning_no==2){
                                        hphtText2 = backend.get_hpht()
                                        cvdText2 = backend.get_cvd()
                                        rftText2 = backend.get_rft()
                                        allText2 = backend.get_all()
                                        cvd_tText2 = backend.get_cvd_t()
                                    }else if(scanning_no==3){
                                        hphtText3 = backend.get_hpht()
                                        cvdText3 = backend.get_cvd()
                                        rftText3 = backend.get_rft()
                                        allText3 = backend.get_all()
                                        cvd_tText3 = backend.get_cvd_t()
                                    }else if(scanning_no==4){
                                        hphtText4 = backend.get_hpht()
                                        cvdText4 = backend.get_cvd()
                                        rftText4 = backend.get_rft()
                                        allText4 = backend.get_all()
                                        cvd_tText4 = backend.get_cvd_t()
                                    }
                                }else{
                                    hphtText = backend.get_hpht()
                                    cvdText = backend.get_cvd()
                                    rftText = backend.get_rft()
                                    allText = backend.get_all()
                                    cvd_tText = backend.get_cvd_t()
                                }
                            }else{
                                hphtText = "-"
                                cvdText = "-"
                                rftText = "-"
                                allText = "-"
                                cvd_tText = "-"
                                manualText = "-"
                                hphtText1 = "-"
                                cvdText1 = "-"
                                rftText1 = "-"
                                allText1 = "-"
                                cvd_tText1 = "-"
                                manualText1 = "-"
                                hphtText2 = "-"
                                cvdText2 = "-"
                                rftText2 = "-"
                                allText2 = "-"
                                cvd_tText2 = "-"
                                manualText2 = "-"
                                hphtText3 = "-"
                                cvdText3 = "-"
                                rftText3 = "-"
                                allText3 = "-"
                                cvd_tText3 = "-"
                                manualText3 = "-"
                                hphtText4 = "-"
                                cvdText4 = "-"
                                rftText4 = "-"
                                allText4 = "-"
                                cvd_tText4 = "-"
                                manualText4 = "-"
                            }
                        }
                    }
                    else{
                        messageDialogText = "Scan is not Completed"
                        messageDialog.visible = true
                        scancircularProgressBar.visible = false
                        busyLabel.visible = false
                    } 
                }
                isMark = isAutomark
                capture_date = backend.getDate()
                timestamp = backend.getTime()
                if(isRotateScan==true){
                    chat_model.make_message(folderNo, sku, lot, type, _size, remarks, capture_date, timestamp, folder_name, 0, isRotateScan, hphtText1, cvdText1,  rftText1, allText1, cvd_tText1, manualText1, hphtText2, cvdText2,  rftText2, allText2, cvd_tText2, manualText2, hphtText3, cvdText3,  rftText3, allText3, cvd_tText3, manualText3,  hphtText4, cvdText4,  rftText4, allText4, cvd_tText4, manualText4);
                }else{
                    chat_model.make_message(folderNo, sku, lot, type, _size, remarks, capture_date, timestamp, folder_name, 0, isRotateScan, hphtText, cvdText,  rftText, allText, cvd_tText, manualText, 0,0,0,0,0,0, 0,0,0,0,0,0, 0,0,0,0,0,0);
                }
                scanning_no -= 1
                isSave = false
                saved_once = false
                tempNo = backend.get_tempNo()
                folderName = "temp"+tempNo
                scancircularProgressBar.visible = false
                showGain = false
                showSimulant = false
                isSuperimage = extraGain
                rotationgroupindex = 1
                image1path = ""
                image2path = ""
                zoomviewimage1path = ""
                zoomviewimage2path = ""
                zoomviewimage1pathresult = ""
                if(isRotateScan==false){
                    image1path = folder+folderName+"/result.jpg"
                    image2path = folder+folderName+"/fluorescence.jpg"
                    // image3path = folder+folderName+"/shortphosphorescence.jpg"
                    // image4path = folder+folderName+"/longphosphorescence.jpg"
                    zoomviewimage1path = folder+folderName+"/result.jpg"
                    zoomviewimage2path = folder+folderName+"/shortphosphorescence.jpg"
                    zoomviewimage1pathresult = folder+folderName+"/result1.jpg"
                }else{
                    image1path = folder+folderName+"/"+scanning_no+"/result.jpg"
                    image2path = folder+folderName+"/"+scanning_no+"/fluorescence.jpg"
                    // image3path = folder+folderName+"/"+scanning_no+"/shortphosphorescence.jpg"
                    // image4path = folder+folderName+"/"+scanning_no+"/longphosphorescence.jpg"
                    zoomviewimage1path = folder+folderName+"/"+scanning_no+"/result.jpg"
                    zoomviewimage2path = folder+folderName+"/"+scanning_no+"/shortphosphorescence.jpg"
                    zoomviewimage1pathresult = folder+folderName+"/"+scanning_no+"/result1.jpg"
                }
                print("image1path : ", image1path)
                r1label = "Result"
                r2label = "Fluorescence"
                r3label = showGain ? qsTr("Super Image") : qsTr("Short Phosphorescence")
                r4label = showSimulant ? qsTr("Simulants") : qsTr("Long Phosphorescence")
                r1borderColor = colorshade7
                r2borderColor = colorshade7
                r3borderColor = colorshade7
                r4borderColor = colorshade7
                zoomview2labeltext = r3label  
                //     }
                // }
                //     else{
                //         if(newScan){
                //             check = false
                //             if(isAutomark){
                //                 hphtText1 = backend.get_hpht()
                //                 cvdText1 = backend.get_cvd()
                //                 rftText1 = backend.get_rft()
                //                 allText1 = backend.get_all()
                //             }else{
                //                 hphtText1 = "-"
                //                 cvdText1 = "-"
                //                 rftText1 = "-"
                //                 allText1 = "-"
                //             }
                //             hphtText2 = "-"
                //             cvdText2 = "-"
                //             rftText2 = "-"
                //             allText2 = "-"
                //             capture_date = backend.getDate()
                //             timestamp = backend.getTime()
                //             chat_model1.make_message(folderNo, sku, lot, type, _size, remarks, capture_date, timestamp, folder_name, 0, hphtText1, cvdText1,  rftText1, allText1);
                //             image1path = verifyfolder+folderName+"/1/result.jpg"
                //             image2path = "file:./logo.png"
                //             image3path = verifyfolder+folderName+"/1/shortphosphorescence.jpg"
                //             image4path = "file:./logo.png"
                //         }else{
                //             if(isAutomark){
                //                 hphtText2 = backend.get_hpht()
                //                 cvdText2 = backend.get_cvd()
                //                 rftText2 = backend.get_rft()
                //                 allText2 = backend.get_all()
                //             }else{
                //                 hphtText2 = "-"
                //                 cvdText2 = "-"
                //                 rftText2 = "-"
                //                 allText2 = "-"
                //             }
                //             image1path = verifyfolder+folder_name+"/1/result.jpg"
                //             image2path = verifyfolder+folderName+"/2/result.jpg"
                //             image3path = verifyfolder+folder_name+"/1/shortphosphorescence.jpg"
                //             image4path = verifyfolder+folderName+"/2/shortphosphorescence.jpg"
                //         }
                        // r1label = "Old Result"
                        // r2label = "New Result"
                        // r3label = "Old Short Phosphorescence"
                        // r4label = "New Short Phosphorescence"
                    // }
                busyLabelText = ""
                rowindex = -1
                internal.enableLayout(true)
                compareButton.clicked()
                backend.setLotno("")
                backend.setSkuno("")
                statusLabeltext = "scanning completed"
            }else{
                backend.stopCamera()
                timer_sleep.running = false
                messageDialogText = "Please close the door"
                scancircularProgressBar.visible = false
                busyLabel.visible = false
                messageDialog.visible = true
            }
        }
    }
    Column{
        id: columnHomeright
        spacing: homeRight.width*0.03
        anchors.top: parent.top
        anchors.topMargin: homeRight.width*0.01
        anchors.horizontalCenter: parent.horizontalCenter
        Rectangle{
            color: colorshade1
            width: homeRight.width*0.9
            height: homeRight.width*0.55
            radius: width*0.02
            border.color: colorshade8
            border.width: bordermargin
            
            Row{
                // x: homeRight.width*0.12
                y: homeRight.width*0.02
                spacing: homeRight.width*0.04
                anchors.horizontalCenter: parent.horizontalCenter
                Column{
                    // anchors.horizontalCenter: parent.horizontalCenter
                    spacing: 15
                    NewControl.ButtonGroup { id: preview_group }
                    anchors.verticalCenter: parent.verticalCenter

                    NewControl.Label{
                        id: roilabel
                        color: colortext
                        // y: roicombo.height/5
                        text: qsTr("Selection Area : ")
                        // font.pointSize: homeRight.width*0.02916
                        font.pointSize: pointSize12
                        font.family: "Segoe UI"
                        Layout.preferredWidth : homeRight.width*0.16
                        // anchors.top: parent.top
                        // anchors.topMargin: homeRight.width*0.015
                        anchors.horizontalCenter: parent.horizontalCenter
                    }
                    CustomRadioButton {
                        id: preview_group_btn1
                        // _width: parseInt(parent.width*0.85)
                        // _height: parseInt(parent.width*0.3)
                        text: qsTr("Full  ")
                        font.pointSize: pointSize12
                        NewControl.ButtonGroup.group: preview_group
                        Layout.preferredWidth : homeRight.width*0.16
                        anchors.horizontalCenter: parent.horizontalCenter
                        onClicked:{
                            roirectcustom_size = roirectinner.width
                            roirectcustom.x = 0
                            roirectcustom.y = 0
                            internal.roiUpdate()
                        }
                    }
                    CustomRadioButton {
                        id: preview_group_btn2
                        // _width : parseInt(parent.width*0.85)
                        // _height: parseInt(parent.width*0.3)
                        text: qsTr("Quarter")
                        font.pointSize: pointSize12
                        NewControl.ButtonGroup.group: preview_group
                        Layout.preferredWidth : homeRight.width*0.16
                        anchors.horizontalCenter: parent.horizontalCenter
                        onClicked:{
                            roirectcustom_size = roirectinner.width/2
                            roirectcustom.x = 0
                            roirectcustom.y = 0
                            internal.roiUpdate()
                        }
                    }
                    CustomRadioButton {
                        id: preview_group_btn3
                        // _width : parseInt(parent.width*0.85)
                        // _height: parseInt(parent.width*0.3)
                        text: qsTr("Custom")
                        font.pointSize: pointSize12
                        NewControl.ButtonGroup.group: preview_group
                        Layout.preferredWidth : homeRight.width*0.16
                        anchors.horizontalCenter: parent.horizontalCenter
                        onClicked:{
                            roirectcustom_size = roirectinner.width/2
                            roirectcustom.x = roirectinner.width/4
                            roirectcustom.y = roirectinner.height/4
                            internal.roiUpdate()
                        }
                    }
                    CustomButton {
                        id: btnroiupdate
                        width: homeRight.width*0.18
                        height: homeRight.width*0.05
                        btnRadius: height*0.33
                        borderWidth: bordermargin
                        // font.pointSize: homeRight.width*0.025
                        font.pointSize: pointSize12
                        anchors.horizontalCenter: parent.horizontalCenter
                        text: qsTr("Update")
                        visible: true
                        Layout.preferredWidth : homeRight.width*0.16
                        onClicked: {
                            internal.roiUpdate()
                        }
                    }
                    // CustomComboBox{
                    //     id: roicombo
                    //     width: homeRight.width*0.1
                    //     height: homeRight.width*0.06
                    //     radius: height*0.3
                    //     // font.pointSize: homeRight.width*0.025
                    //     font.pointSize: pointSize12
                    //     borderWidth: bordermargin
                    //     model: [ "Full", "Grid", "Custom"]
                    //     onActivated: {
                    //         if(roicombo.currentIndex==0){
                    //             roirectcustom_size = roirectinner.width
                    //             roirectcustom.x = 0
                    //             roirectcustom.y = 0
                    //         }
                    //         else if(roicombo.currentIndex==1){
                    //             roirectcustom_size = roirectinner.width/2
                    //             roirectcustom.x = 0
                    //             roirectcustom.y = 0
                    //         }
                    //         else if(roicombo.currentIndex==2){
                    //             roirectcustom_size = roirectinner.width/2
                    //             roirectcustom.x = roirectinner.width/4
                    //             roirectcustom.y = roirectinner.height/4
                    //         }
                    //     }
                    // }
                    // CustomCircularButton{
                    //     height: homeRight.width*0.08
                    //     width: homeRight.width*0.08
                    //     btnIconSource : "../../images/svg_images/refresh.svg"
                    //     CustomToolTip {
                    //         text: "Preview Selection Area"
                    //     }
                    //     onClicked: {
                    //         backend.reset_roi()
                    //         backend.stopCamera()
                    //         backend.captureLive()
                    //         imageselection.source = folder+"/live.jpg"
                    //     }
                    // }
                }
                Rectangle{
                    id: roirectouter
                    // x: homeRight.width*0.05
                    width: parseInt(homeRight.width*0.62)
                    height: parseInt((homeRight.width*0.62)/1.21)
                    color: "transparent"
                    border.color: colorshade8
                    border.width: bordermargin
                    // anchors.horizontalCenter: parent.horizontalCenter
                    clip: true
                    Image{
                        id : imageselection
                        anchors.fill : parent
                        fillMode: Image.PreserveAspectFit
                        source: folder+"live.jpg"
                        // width: homeRight.width*0.90
                        // height: homeRight.width*0.90
                    }
                    Rectangle{
                        id: roirectinner
                        anchors.fill: parent
                        anchors.margins : 4
                        color: "transparent"
                        clip: true
                        visible: true
                        CustomButton{
                            id: roiselection1
                            anchors.top: parent.top
                            colorDefault : "transparent"
                            colorMouseOver : "transparent"
                            colorPressed : "transparent"
                            anchors.left: parent.left
                            width: roirectinner.width/2
                            height: roirectinner.height/2
                            text: "1"
                            // colorDefault: colorshade2
                            btnRadius: 0
                            borderWidth: bordermargin
                            // visible: (roicombo.currentIndex==1) ? true : false
                            visible: preview_group_btn2.checked ? true : false
                            // z : 0
                            onClicked: {    
                                roirectcustom_size = roirectinner.width/2
                                roirectcustom.x = 0
                                roirectcustom.y = 0
                                internal.roiUpdate()
                            }
                        }
                        CustomButton{
                            id: roiselection2
                            colorDefault : "transparent"
                            colorMouseOver : "transparent"
                            colorPressed : "transparent"
                            anchors.top: parent.top
                            anchors.right: parent.right
                            width: roirectinner.width/2
                            height: roirectinner.height/2
                            text: "2"
                            // colorDefault: colorshade2
                            btnRadius: 0
                            borderWidth: bordermargin
                            // visible: (roicombo.currentIndex==1) ? true : false
                            visible: preview_group_btn2.checked ? true : false
                            // z : 0
                            onClicked: {    
                                roirectcustom_size = roirectinner.width/2
                                roirectcustom.x = roirectinner.width/2
                                roirectcustom.y = 0
                                internal.roiUpdate()
                            }
                        }
                        CustomButton{
                            id: roiselection3
                            colorDefault : "transparent"
                            colorMouseOver : "transparent"
                            colorPressed : "transparent"
                            anchors.bottom: parent.bottom
                            anchors.left: parent.left
                            width: roirectinner.width/2
                            height: roirectinner.height/2
                            text: "3"
                            // colorDefault: colorshade2
                            btnRadius: 0
                            borderWidth: bordermargin
                            // visible: (roicombo.currentIndex==1) ? true : false
                            visible: preview_group_btn2.checked ? true : false
                            // z : 0
                            onClicked: {  
                                roirectcustom_size = roirectinner.width/2
                                roirectcustom.x = 0
                                roirectcustom.y = roirectinner.height/2
                                internal.roiUpdate()
                            }
                        }
                        CustomButton{
                            id: roiselection4
                            colorDefault : "transparent"
                            colorMouseOver : "transparent"
                            colorPressed : "transparent"
                            anchors.bottom: parent.bottom
                            anchors.right: parent.right
                            width: roirectinner.width/2
                            height: roirectinner.height/2
                            text: "4"
                            // colorDefault: colorshade2
                            btnRadius: 0
                            borderWidth: bordermargin
                            // visible: (roicombo.currentIndex==1) ? true : false
                            visible: preview_group_btn2.checked ? true : false
                            // z : 0
                            onClicked: {   
                                roirectcustom_size = roirectinner.width/2
                                roirectcustom.x = roirectinner.width/2
                                roirectcustom.y = roirectinner.height/2
                                internal.roiUpdate()
                            }
                        }
                        Rectangle{
                            id: roirectcustom
                            x: 0
                            y: 0
                            width: roirectcustom_size
                            height: roirectcustom_size/1.22
                            color: "transparent"
                            border.color: colorshade5
                            border.width: bordermargin
                            
                            MouseArea {
                                anchors.fill: parent
                                drag.target: roirectcustom
                                drag.minimumX: 0
                                drag.maximumX: roirectinner.width - roirectcustom.width
                                drag.minimumY: 0
                                drag.maximumY: roirectinner.height - roirectcustom.height
                                onWheel: {
                                    if(preview_group_btn3.checked){
                                        if (wheel.angleDelta.y > 0 & roirectcustom_size<roirectinner.width)
                                        {
                                            roirectcustom_size = roirectcustom_size+roirectinner.width*0.01
                                        }
                                        else if(wheel.angleDelta.y > 0 & roirectcustom_size>=(roirectinner.width))
                                        {
                                            roirectcustom_size = roirectinner.width
                                        }
                                        else if(wheel.angleDelta.y < 0 & roirectcustom_size<=(roirectinner.width/4))
                                        {
                                            roirectcustom_size = roirectinner.width/4
                                        }
                                        else if(wheel.angleDelta.y < 0 & roirectcustom_size>(roirectinner.width/4))
                                        {
                                            roirectcustom_size = roirectcustom_size-roirectinner.width*0.01
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // CustomButton {
        //     id: btnroiupdate
        //     width: parseInt(homeRight.width*0.42)
        //     height: parseInt(homeRight.width*0.085)
        //     btnRadius: height*0.33
        //     borderWidth: bordermargin
        //     // font.pointSize: homeRight.width*0.025
        //     font.pointSize: pointSize10
        //     anchors.horizontalCenter: parent.horizontalCenter
        //     text: qsTr("Update Selection Area")
        //     visible: true
        //     onClicked: {
        //         const p1 = roirectcustom.x/roirectinner.width
        //         const p2 = roirectcustom.y/roirectinner.height
        //         const p3 = parseInt(roirectcustom.width)/roirectinner.width
        //         const p4 = parseInt(roirectcustom.width)/roirectinner.width
        //         for (var j = 0; j < 7; j++)  {
        //             backend.setSelection(j)
        //             backend.setParameter(1)
        //             backend.set_tuple(p1, 0)
        //             backend.set_tuple(p2, 1)
        //             backend.set_tuple(p3, 2)
        //             backend.set_tuple(p4, 3)
        //             backend.write_file()
        //         }
        //         busyLabelText = ""
        //         backend.stopCamera()
        //         backend.startCamera()
        //         timer_sleep.restart()
        //     }
        // }
        Row{
            visible: !scanMode
            spacing: homeRight.width*0.02
            // padding: homeRight.width*0.01
            CustomRadioButton {
                id: newscanbtn
                _width : homeRight.width*0.42
                _height: homeRight.width*0.11
                text: qsTr("New Record")
                font.pointSize: pointSize10
                borderWidth: bordermargin
                checked: newScan1
                onClicked:{
                    newScan1 = true
                    backend.newScanSelection(newScan1)
                    newScan = false
                    internal.resetSelection()
                }
            }
            CustomRadioButton {
                id: rescanbtn
                _width : homeRight.width*0.42
                _height: homeRight.width*0.11
                text: qsTr("Select Record")
                font.pointSize: pointSize10
                borderWidth: bordermargin
                checked: !newScan1
                onClicked:{
                    newScan1 = false
                    backend.newScanSelection(newScan1)
                    newScan = true
                    historyButton.clicked()
                }
            }
        }
        CustomText{
            id: folderText
            width: homeRight.width*0.83
            height: homeRight.width*0.1
            readOnly : true
            rad: height*0.33
            // font.pointSize: resultLeft.width*0.0347
            font.pointSize: pointSize10
            borderWidth: bordermargin
            text: folder_name
            visible: (newScan1==false & newScan==false) ? true : false
        }
        Rectangle {
            id: focusbox
            color: colorshade1
            width: homeRight.width*0.90
            height: homeRight.width*0.18
            radius: width*0.02
            border.color: colorshade8
            border.width: bordermargin
        
            CustomSlider{
                id: focusslider
                anchors.top: parent.top
                anchors.topMargin: focusbox.height*0.14
                anchors.horizontalCenter: focusbox.horizontalCenter
                sliderWidth: focusbox.width*0.92
                sliderHieght: focusbox.height*0.03
                focusPolicy: Qt.StrongFocus
                snapMode: NewControl.RangeSlider.SnapOnRelease
                stepSize: 2
                to: 4095
                value: focus_value
                activeFocusOnTab: true
                CustomToolTip {
                    text: "Focus"
                }
                onMoved: {
                    backend.setfocus(focusslider.value)
                    focus_value = focusslider.value
                }
            }
            Row{
                spacing: 15
                anchors.top: focusslider.bottom
                anchors.topMargin: focusbox.height*0.16
                anchors.bottom: focusbox.bottom
                anchors.bottomMargin: focusbox.width*0.05
                anchors.horizontalCenter: parent.horizontalCenter
                CustomCircularButton {
                    id: focusvalueminus
                    width: focusbox.height*0.30
                    height: focusbox.height*0.30
                    btnRadius: height*0.5
                    iconSize: height*0.6
                    // anchors.top: focusslider.bottom
                    // anchors.topMargin: focusbox.height*0.18
                    // anchors.left: focusbox.left
                    // anchors.leftMargin: focusbox.width*0.05
                    anchors.verticalCenter: parent.verticalCenter
                    btnColorClicked: colorshade5
                    btnColorMouseOver: colorshade6
                    btnIconSource: "../../images/minus.png"
                    CustomToolTip {
                        text: "Focus Minus" 
                    }
                    onPressed: {
                        if (focus_value < 10){
                            focus_value = 0
                        }else{
                            focus_value = focus_value - 10
                        }
                        backend.setfocus(focus_value)
                        focusslider.value = focus_value
                        focusvalue.text = focus_value
                    }
                }
                CustomTextField{
                    id: focusvalue
                    width: focusbox.width*0.2
                    height: focusbox.height*0.25
                    rad: height*0.25
                    // validator: IntValidator {bottom: 0; top: 4095;}
                    text: focus_value
                    // anchors.top: focusslider.bottom
                    // anchors.topMargin: focusbox.height*0.18
                    // anchors.left: focusvalueminus.right
                    // anchors.leftMargin: focusbox.width*0.05
                    anchors.verticalCenter: parent.verticalCenter
                    font.pointSize: pointSize12
                    borderWidth: bordermargin
                    activeFocusOnTab: true
                    CustomToolTip {
                        text: "Focus"
                    }
                    onEditingFinished: {
                        if (focusvalue.text < 4096){
                            focus_value = focusvalue.text 
                        }else{
                            focus_value = 4095
                            focusvalue.text = 4095
                        }
                        backend.setfocus(focus_value)
                        focusslider.value = focus_value
                    }
                }
                CustomCircularButton {
                    id: focusvalueplus
                    width: focusbox.height*0.30
                    height: focusbox.height*0.30
                    btnRadius: height*0.5
                    iconSize: height*0.5
                    // anchors.top: focusslider.bottom
                    // anchors.topMargin: focusbox.height*0.18
                    // anchors.left: focusvalue.right
                    // anchors.leftMargin: focusbox.width*0.05
                    anchors.verticalCenter: parent.verticalCenter
                    btnColorClicked: colorshade5
                    btnColorMouseOver: colorshade6
                    btnIconSource: "../../images/plus.png"
                    CustomToolTip {
                        text: "Focus Plus"
                    }
                    onPressed: {
                        if (focus_value < 4086){
                            focus_value = focus_value + 10
                        }else{
                            focus_value = 4095
                        }
                        backend.setfocus(focus_value)
                        focusslider.value = focus_value
                        focusvalue.text = focus_value
                    }
                }
                CustomButton{
                    id: focusvaluebutton
                    width: focusbox.width*0.3
                    height: focusbox.height*0.25
                    btnRadius: height*0.25
                    text: "Auto Focus"
                    // colorPressed: colorshade4
                    colorMouseOver: colorshade3
                    colorDefault: colorshade1
                    colorText: colorshade5
                    font.pointSize: pointSize12
                    borderWidth: bordermargin
                    font.family: "Segoe UI"
                    // anchors.top: focusslider.bottom
                    // anchors.topMargin: focusbox.height*0.18
                    // anchors.right: focusbox.right
                    // anchors.rightMargin: focusbox.width*0.05
                    anchors.verticalCenter: parent.verticalCenter
                    activeFocusOnTab: true
                    property var f
                    Keys.onReturnPressed: {
                        focusvaluebutton.clicked()
                    }
                    onClicked: {
                        if(isHome){
                            f = backend.setautofocus()
                            timer_focus.running = true
                            timer2.running = true
                        }
                    }
                }
            }
        }
        Row{
            y: homeRight.width*0.03
            spacing: homeRight.width*0.05
            anchors.horizontalCenter: parent.horizontalCenter
            GridLayout {
                columns: 2
                rows: 10
                rowSpacing: homeRight.width*0.0125
                columnSpacing: 0
                enabled: newScan1
                opacity: newScan1 ? 1 : 0.4
                anchors.verticalCenter: parent.verticalCenter
                // visible: isHome
                NewControl.Label {
                    id: label1
                    color: colorshade5
                    text: "Lot No"
                        // focus: isHome
                    textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    // font.pointSize: homeRight.width*0.0451
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 0
                    Layout.preferredWidth : homeRight.width*0.15
                }
                CustomTextField{
                    id: text1
                    text: ""
                    width: homeRight.width*0.3
                    height: homeRight.width*0.11
                    rad: height*0.3
                    // font.pointSize: height*0.4
                    font.pointSize: pointSize12
                    borderWidth: bordermargin
                    // focus: true
                    // activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 0
                    Layout.preferredWidth : homeRight.width*0.3
                    // validator: RegExpValidator {
                    //     regExp: RegExp("[a-zA-Z0-9]+")
                    // }
                    onEditingFinished: {
                        lot = text1.text
                        backend.setLotno(text1.text)
                    }
                }
                NewControl.Label {
                    id: label2
                    color: colorshade5
                    text: "Name"
                    textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    // font.pointSize: homeRight.width*0.0451
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 1
                    Layout.preferredWidth : homeRight.width*0.15
                }
                CustomTextField{
                    id: text2
                    text: ""
                    width: homeRight.width*0.3
                    height: homeRight.width*0.11
                    rad: height*0.3
                    // font.pointSize: height*0.4
                    font.pointSize: pointSize12
                    borderWidth: bordermargin
                    // activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 1
                    Layout.preferredWidth : homeRight.width*0.3
                    // validator: RegExpValidator {
                    //     regExp: RegExp("[a-zA-Z0-9]+")
                    // }
                    onEditingFinished: {
                        sku = text2.text
                        backend.setSkuno(text2.text)
                    }
                }
                NewControl.Label {
                    id: label3
                    color: colorshade5
                    text: "Type"
                    textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    // font.pointSize: homeRight.width*0.0451
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 2
                    Layout.preferredWidth : homeRight.width*0.15
                }
                CustomComboBox {
                    id: text3
                    model : ["Loose Diamonds","Melee Diamonds","Ring","Ear Rings","Bangles","Necklace"]
                    editText: ""
                    editable : true
                    currentIndex : -1
                    width: homeRight.width*0.3
                    height: homeRight.width*0.11
                    radius: height*0.3
                    font.pointSize: pointSize10
                    borderWidth: bordermargin
                    activeFocusOnTab: true
                    // activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 2
                    Layout.preferredWidth : homeRight.width*0.3
                    // validator: RegExpValidator {
                    //     regExp: RegExp("[0-9]+")
                    // }
                    onAccepted: {
                        type = text3.editText
                    }
                }
                NewControl.Label {
                    id: label4
                    color: colorshade5
                    text: "Size"
                    textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    // font.pointSize: homeRight.width*0.0451
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 3
                    Layout.preferredWidth : homeRight.width*0.15
                }
                CustomTextField{
                    id: text4
                    text: ""
                    width: homeRight.width*0.3
                    height: homeRight.width*0.11
                    rad: height*0.3
                    // font.pointSize: height*0.4
                    font.pointSize: pointSize12
                    borderWidth: bordermargin
                    // activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 3
                    Layout.preferredWidth : homeRight.width*0.3
                    // validator: RegExpValidator {
                    //     regExp: RegExp("[a-zA-Z0-9]+")
                    // }
                    onEditingFinished: {
                        _size = text4.text
                    }
                }
                NewControl.Label {
                    id: label5
                    color: colorshade5
                    enabled: newScan1
                    opacity: newScan1 ? 1 : 0.4
                    text: "Remarks"
                    textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    // font.pointSize: homeRight.width*0.0451
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 4
                    Layout.preferredWidth : homeRight.width*0.15
                }
                CustomTextField{
                    id: text5
                    text: ""
                    enabled: newScan1
                    opacity: newScan1 ? 1 : 0.4
                    width: homeRight.width*0.3
                    height: homeRight.width*0.11
                    rad: height*0.3
                    // font.pointSize: height*0.2
                    font.pointSize: pointSize12
                    borderWidth: bordermargin
                    Layout.column: 1
                    Layout.row: 4
                    Layout.preferredWidth : homeRight.width*0.3
                    // Layout.preferredHeight : homeRight.width*0.1
                    activeFocusOnTab: true
                    onEditingFinished: {
                        remarks = text5.text
                    }
                } 
            }
            GridLayout {
                columns: 2
                rows: 10
                enabled: newScan1
                opacity: newScan1 ? 1 : 0.4
                rowSpacing: homeRight.width*0.008
                columnSpacing: 0
                visible: isHome
                anchors.verticalCenter: parent.verticalCenter
                NewControl.Label {
                    // id: label6
                    color: colorshade5
                    text: "360 Rotation"
                    // textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 0
                    Layout.preferredWidth : homeRight.width*0.18
                }
                CustomSwitch {
                    id: rotationswitch
                    text: qsTr(" ")
                    checked: isRotateScan
                    activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 0
                    Layout.preferredWidth : homeRight.width*0.12
                    Keys.onPressed: {
                        if (event.key === Qt.Key_Return || event.key === Qt.Key_Enter) {
                            rotationswitch.toggle()
                            rotationswitch.toggled()
                        }
                    }
                    onToggled: {
                        print("rotationswitch toggled")
                        isRotateScan = checked ? true : false
                        isrotation = checked ? true : false
                        backend.enable_rotation(isRotateScan)
                    } 
                }
                NewControl.Label {
                    id: label6
                    color: colorshade5
                    text: "Super Image"
                    // textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 1
                    Layout.preferredWidth : homeRight.width*0.18
                }
                CustomSwitch {
                    id: gainswitch
                    text: qsTr(" ")
                    checked: extraGain
                    activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 1
                    Layout.preferredWidth : homeRight.width*0.12
                    Keys.onPressed: {
                        if (event.key === Qt.Key_Return || event.key === Qt.Key_Enter) {
                            gainswitch.toggle()
                            gainswitch.toggled()
                        }
                    }
                    onToggled: {
                        print("gainswitch toggled")
                        extraGain = checked
                        backend.enable_gain(extraGain)
                    } 
                }
                NewControl.Label {
                    id: label7
                    color: colorshade5
                    text: "AI Marking"
                    // textFormat: Text.RichText
                    anchors.horizontalCenterOffset: 0
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 2
                    Layout.preferredWidth : homeRight.width*0.18
                }
                CustomSwitch {
                    id: markswitch
                    text: qsTr(" ")
                    checked: isAutomark
                    activeFocusOnTab: true
                    Layout.column: 1
                    Layout.row: 2
                    Layout.preferredWidth : homeRight.width*0.12
                    Keys.onPressed: {
                        if (event.key === Qt.Key_Return || event.key === Qt.Key_Enter) {
                            markswitch.toggle()
                            markswitch.toggled()
                        }
                    }
                    onToggled: {
                        isAutomark = checked
                        backend.enable_marking(checked)
                    } 
                }
                NewControl.Label{
                    id: autosavebtn
                    color: colorshade5
                    text: qsTr("Auto Save")
                    font.family: "Segoe UI"
                    font.bold: false
                    font.weight: Font.Normal
                    font.pointSize: pointSize13
                    Layout.column: 0
                    Layout.row: 3
                }
                CustomSwitch {
                    id: autosaveswitch
                    text: qsTr(" ")
                    checked: isAutosave
                    Layout.column: 1
                    Layout.row: 3
                    Layout.preferredWidth : homeRight.width*0.12
                    activeFocusOnTab: true
                    Keys.onPressed: {
                        if (event.key === Qt.Key_Return || event.key === Qt.Key_Enter) {
                            autosaveswitch.toggle()
                            autosaveswitch.toggled()
                        }
                    }
                    onToggled: {
                        // if(isAutosave==true){
                        //     isAutosave = false
                        // }
                        // else{
                        //     isAutosave = true
                        // }
                        isAutosave = checked
                    }
                }
                CustomButton{
                    id: scanButton
                    text: "Scan"
                    enabled: isHome
                    width: homeRight.width*0.25
                    height: homeRight.width*0.1
                    // opacity: enabled ? 1 : 0.4
                    // iconLeftPosition: flickable.height*0.03
                    // iconTopPosition: flickable.height*0.0375
                    // textLeftPosition: flickable.height*0.03
                    // textBottomPosition: flickable.height*0.03
                    btnRadius: height*0.5
                    borderWidth: bordermargin
                    font.pointSize: pointSize18
                    activeFocusOnTab: true
                    Layout.column: 0
                    Layout.row: 4
                    // NewControl.ButtonGroup.group: appgroup
                    // Layout.alignment: Qt.AlignHCenter | Qt.AlignVCenter
                    Layout.preferredHeight : homeRight.width*0.1
                    Layout.preferredWidth : homeRight.width*0.25
                    Layout.columnSpan: 2
                    // Layout.rowSpan: 2
                    signal refresh()
                    
                    onClicked: {
                        if(isHome == true){
                            gc();
                            scanButton.focus = true
                            scanButton.checked = true
                            scancircularProgressBar.visible = true
                            busyLabelText = "Scanning..."
                            statusLabeltext = "scanning in process"
                            backend.stopCamera()
                            timer_sleep.running = false
                            internal.enableLayout(false)
                            door = backend.checkDoor()
                            refresh()
                            internal.capture(door)
                        }
                    }
                }
            }
        }
        NewControl.Label {
            id: label8
            color: colorshade5
            textFormat: Text.RichText
            anchors.horizontalCenterOffset: 0
            font.family: "Segoe UI"
            font.bold: false
            font.weight: Font.Normal
            font.pointSize: pointSize12
        }
    }
}