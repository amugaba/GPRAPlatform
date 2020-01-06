<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Search GPRA Assessments for Export</div>
    <form @submit.prevent="searchGPRAs" style="text-align: center; max-width: 300px; margin: 0 auto">
        <input type="text" v-model="autoID" placeholder="Auto ID" class="input-block">
        <input type="text" v-model="clientID" placeholder="Client ID" class="input-block">
        <input type="text" v-model="startDate" placeholder="From Start Date (yyyy-mm-dd)" class="input-block">
        <input type="text" v-model="endDate" placeholder="Through End Date" class="input-block">
        <input type="submit" value="Search GPRAs" class="btn btn-primary"><br>
        <label><input type="checkbox" v-model="unexportedOnly"> Find un-exported only</label>
    </form>

    <b-table :fields="tableFields" :items="gpras" :per-page="10" :current-page="currentPage" hover bordered sort-by="id" :sort-desc="true">
        <template v-slot:cell(select)="data">
            <input type="checkbox" v-model="selectedGPRAs" :value="data.item.id">
        </template>
        <template v-slot:cell(id)="data">
            {{data.item.id}}
        </template>
        <template v-slot:cell(client_id)="data">
            {{data.item.client_id}}
        </template>
        <template v-slot:cell(interview_date)="data">
            {{data.item.interview_date | date}}
        </template>
        <template v-slot:cell(completed)="data">
            {{data.item.status | yn}}
        </template>
        <template v-slot:cell(interview_conducted)="data">
            {{data.item.interview_conducted | yn}}
        </template>
        <template v-slot:cell(exported)="data">
            {{data.item.exported | yn}}
        </template>
    </b-table>
    <b-pagination v-show="gpras.length>15" :total-rows="gpras.length" :per-page="10" v-model="currentPage" style="float: right; margin-top: 0"></b-pagination>

    <div class="text-center">
        <input type="button" value="Export JSON" class="btn btn-primary" @click="exportGPRAs">
    </div>

    <div class="text-center">
        <input type="button" value="Set Uploaded" class="btn btn-primary" @click="setExported(true)">
        <input type="button" value="Set NOT Uploaded" class="btn btn-primary" @click="setExported(false)">
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script src="/js/spars_upload.js"></script>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main',
            data: {
                gpras: [],
                selectedGPRAs: [],
                autoID: null,
                clientID: null,
                startDate: null,
                endDate: null,
                unexportedOnly: true,
                tableFields: [
                    {key: 'select', label: 'Select', sortable: false},
                    {key: 'id', label: 'Auto ID', sortable: true},
                    {key: 'client_id', label: 'Client', sortable: true},
                    {key: 'interview_date', label: 'Interview Date', sortable: true},
                    {key: 'completed', label: 'Completed', sortable: true},
                    {key: 'interview_conducted', label: 'Did Interview', sortable: true},
                    {key: 'exported', label: 'Uploaded', sortable: true}
                ],
                currentPage: 1
            },
            methods: {
                searchGPRAs: function () {
                    ajax('/report/searchGPRAs',[this.autoID, this.clientID, this.startDate, this.endDate, this.unexportedOnly], function (result) {
                        vue.gpras = result.data;
                    });
                },
                exportGPRAs: function () {
                    if(this.selectedGPRAs.length === 0 )
                        return;
                    ajax('/report/exportGPRAs',[this.selectedGPRAs], function (result) {
                        let exported = result.data;
                        let file = new Blob([JSON.stringify(exported)], {type: 'text/plain'});
                        let a = document.createElement("a");
                        a.href = URL.createObjectURL(file);
                        a.download = "gpraExport.json";
                        a.click();
                    });
                },
                setExported: function (isExported) {
                    if(this.selectedGPRAs.length === 0 )
                        return;
                    ajax('/report/setExported',[this.selectedGPRAs, isExported]);
                }
            }
        });
    </script>
</body>
</html>