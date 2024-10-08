  (function ($) {
            $.fn.jointer = function (connectionColor, connectionCircleColor, useMargin) {
                this.connectionColor = connectionColor || 'black';
                this.connectionCircleColor = connectionCircleColor || 'black';
                this.useMargin = useMargin || !1;
                this.jointerConnectionsStore = [];
                this.connectElements = ((from, to) => {
                    if (checkIfElementExists(from) && checkIfElementExists(to)) {
                        let cTy;
                        let cTx;
                        let id = guid();
                        let fromX = $(from).position().left + ($(to).width() / 2);
                        let fromY = $(from).position().top + ($(from).height() / 2);
                        let targetX = $(to).position().left + ($(to).width() / 2);
                        let targetY = $(to).position().top + ($(to).height() / 2);
                        if (targetY > fromY) {
                            if (this.useMargin) {
                                cTy = $(to).position().top + getTopMargin(to);
                                cTx = targetX
                            } else {
                                cTy = $(to).position().top;
                                cTx = targetX
                            }
                        }
                        if (targetY < fromY) {
                            if (this.useMargin) {
                                cTy = $(to).position().top + ($(to).height() + getTopMargin(to));
                                cTx = targetX
                            } else {
                                cTy = $(to).position().top + $(to).height();
                                cTx = targetX
                            }
                        }
                        $('.jointerArea').prepend('<svg id="' + id +
                            '" style="position: absolute; top: 0px; z-index: 1;">' + '<line x1="' +
                            fromX + '" y1="' + fromY + '" x2="' + cTx + '"y2="' + cTy +
                            '" stroke="' + this.connectionColor + '"/>' + '</svg>');
                        this.jointerConnectionsStore.push({
                            from: $(from).attr('id'),
                            to: $(to).attr('id'),
                            connectionId: id
                        })
                    } else {
                        throw new Error("elements not found in DOM")
                    }
                });
                this.clearConnection = ((el) => {
                    if (!el) {
                        throw new Error("element not defined. can´t clear connections")
                    }
                    if ($(el).attr('id') !== "undefined") {
                        let removeConnections = [];
                        $.each(this.jointerConnectionsStore, (i, e) => {
                            if ($(el).attr('id') == e.from) {
                                $('#' + e.connectionId).remove();
                                removeConnections.push(e)
                            }
                        });
                        for (let i = 0; i < removeConnections.length; i++) {
                            for (let a = 0; a < this.jointerConnectionsStore.length; a++) {
                                if (removeConnections[i].connectionId == this.jointerConnectionsStore[a]
                                    .connectionId) {
                                    this.jointerConnectionsStore.splice(a, 1)
                                }
                            }
                        }
                    }
                });
                this.clearAllConnection = () => {
                    $('body svg').remove()
                };
                return this
            };

            function guid() {
                function s4() {
                    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1)
                }
                return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4()
            }

            function getTopMargin(el) {
                return parseFloat($(el).css('margin-top'))
            }

            function getBottomMargin(el) {
                return parseFloat($(el).css('margin-bottom'))
            }

            function checkIfElementExists(el) {
                if ($(el).length < 1) {
                    return !1
                } else {
                    return !0
                }
            }
        }(jQuery))
        /**
         * made with love from AICDEV
         */
        /**
         * thanks to Jon Surrell for this awesome guid function
         * https://stackoverflow.com/users/1432801/jon-surrell
         */
        (function ($) {
                $.fn.jointer = function (connectionColor, connectionCircleColor, useMargin) {
                    this.connectionColor = connectionColor || 'black';
                    this.connectionCircleColor = connectionCircleColor || 'black';
                    this.useMargin = useMargin || !1;
                    this.jointerConnectionsStore = [];
                    this.connectElements = ((from, to) => {
                            if (checkIfElementExists(from) && checkIfElementExists(to)) {
                                let cTy;
                                let cTx;
                                let id = guid();
                                let fromX = $(from).position().left + ($(to).width() / 2);
                                let fromY = $(from).position().top + ($(from).height() / 2);
                                let targetX = $(to).position().left + ($(to).width() / 2);
                                let targetY = $(to).position().top + ($(to).height() / 2);
                                if (targetY > fromY) {
                                    if (this.useMargin) {
                                        cTy = $(to).position().top + getTopMargin(to);
                                        cTx = targetX
                                    } else {
                                        cTy = $(to).position().top;
                                        cTx = targetX
                                    }
                                }
                                if (targetY < fromY) {
                                    if (this.useMargin) {
                                        cTy = $(to).position().top + ($(to).height() + getTopMargin(to));
                                        cTx = targetX
                                    } else {
                                        cTy = $(to).position().top + $(to).height();
                                        cTx = targetX
                                    }
                                }
                                $('.jointerArea').prepend('<svg id="' + id + '" style="position: absolute; top: 0px; z-index: 1;">' + ' < line x1 = "'+fromX+'" y1 = "'+fromY+'"x2 = "'+cTx+'" y2 = "'+cTy+'" stroke = "'+this.connectionColor+'" / > '+' </svg>');this.jointerConnectionsStore.push({from:$(from).attr('id'),to:$(to).attr('id'),connectionId:id})}else{throw
                                    new Error("elements not found in DOM")
                                }
                            }); this.clearConnection = ((el) => {
                                if (!el) {
                                    throw new Error("element not defined.                                        can´ t clear connections ")} if($(el).attr('id')!=="                                        undefined "){let                                        removeConnections = []; $.each(this.jointerConnectionsStore, (i,
                                            e) => {
                                                if ($(el).attr('id') == e.from) {
                                                    $('#' + e.connectionId).remove();
                                                    removeConnections.push(e)
                                                }
                                            });
                                        for (let i = 0; i < removeConnections.length; i++) {
                                            for (let a = 0; a < this.jointerConnectionsStore.length; a++) {
                                                if (removeConnections[i].connectionId == this
                                                    .jointerConnectionsStore[a].connectionId) {
                                                    this.jointerConnectionsStore.splice(a, 1)
                                                }
                                            }
                                        }
                                    }
                                }); this.clearAllConnection = () => {
                                $('body svg').remove()
                            };
                            return this
                        };

                        function guid() {
                            function s4() {
                                return
                                Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1)
                            }
                            return
                            s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4()
                        }

                        function getTopMargin(el) {
                            return
                            parseFloat($(el).css('margin-top'))
                        }

                        function getBottomMargin(el) {
                            return parseFloat($(el).css('margin-bottom'))
                        }

                        function checkIfElementExists(el) {
                            if ($(el).length < 1) {
                                return !1
                            } else {
                                return !0
                            }
                        }
                    }(jQuery))
                /** * made with love
                           from AICDEV */
                /** * thanks to Jon Surrell for this awesome guid function *
                           https://stackoverflow.com/users/1432801/jon-surrell */