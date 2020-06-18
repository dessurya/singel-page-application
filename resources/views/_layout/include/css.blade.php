<link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('_css/custom.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
    /* scroller */
        /* scroller browser */
            ::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }
        /* scroller browser */

        /* Track */
            ::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 5px rgb(215,215,215); 
                -webkit-border-radius: 10px;
                border-radius: 10px;
            }
        /* Track */

        /* Handle */
            ::-webkit-scrollbar-thumb {
                -webkit-border-radius: 10px;
                border-radius: 10px;
                background: rgb(1,151,88);
                -webkit-box-shadow: inset 0 0 6px rgb(215,215,215); 
            }
            ::-webkit-scrollbar-thumb:window-inactive {
                background: rgb(215,215,215); 
            }
        /* Handle */
    /* scroller */
    /* loading page */
        #loading-page{
            position: fixed;
            top: 0;
            z-index: 99999;
            width: 100vw;
            height: 100vh;
            background-color: rgba(112,112,112,.4);
            transition: all 1.51s;
        }
        #loading-page .dis-table .row .cel{
            text-align: center;
            width: 100%;
            height: 100vh;
        }
    /* loading page */
    .modal{
        z-index: 9999;
    }
    .modal-lg{
        width: 75%;
    }
    table#table-data tr,
    table#table-data1 tr{
        cursor: pointer;
    }

    table#table-data tbody tr.selected,
    table#table-data1 tbody tr.selected{
        background-color: #aab7d1;
    }

    .dataTables_wrapper .dataTables_filter{
        display: none;
    }
    
    .btn-group ul#action.dropdown-menu li{
        padding: 5px;
        cursor: pointer;
    }

    form#storeData .x_content #question .row{
        margin-bottom: 20px;
    }

    form#storeData .x_content #question .pageOfQuestion{
        display: none;
    }
</style>