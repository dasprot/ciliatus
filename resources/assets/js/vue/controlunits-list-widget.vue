<template>
    <div>
        <div :class="wrapperClasses">
            <table class="responsive highlight collapsible" data-collapsible="expandable">
                <thead>
                <tr>
                    <th data-field="name">
                        <a href="#!" v-on:click="set_order('name')">{{ $t('labels.name') }}</a>
                        <i v-show="order.field == 'name' && order.direction == 'asc'" class="material-icons">arrow_drop_up</i>
                        <i v-show="order.field == 'name' && order.direction == 'desc'" class="material-icons">arrow_drop_down</i>
                        <div class="input-field inline">
                            <input id="filter_name" type="text" v-model="filter.name" v-on:keyup.enter="set_filter">
                            <label for="filter_name">Filter</label>
                        </div>
                    </th>

                    <th data-field="timestamps.last_heartbeat">
                        {{ $t('labels.last_heartbeat') }}
                    </th>

                    <th style="width: 40px">
                    </th>
                </tr>
                </thead>

                <template v-for="controlunit in controlunits">
                    <tbody>
                        <tr class="collapsible-header">

                            <td>
                                <span>
                                    <i class="material-icons">developer_board</i>
                                    <a v-bind:href="'/controlunits/' + controlunit.id">{{ controlunit.name }}</a>
                                </span>
                            </td>

                            <td>
                                <!-- @TODO: there has to be a better way to do this -->
                                <span v-show="controlunit.timestamps.last_heartbeat_diff.days > 0"
                                      class="tooltipped" data-position="bottom" data-delay="50" v-bind:data-tooltip="controlunit.timestamps.last_heartbeat">
                                    {{ $t('units.days_ago', {val: controlunit.timestamps.last_heartbeat_diff.days}) }}
                                </span>
                                <span v-show="controlunit.timestamps.last_heartbeat_diff.days < 1 &&
                                              controlunit.timestamps.last_heartbeat_diff.hours > 0"
                                      class="tooltipped" data-position="bottom" data-delay="50" v-bind:data-tooltip="controlunit.timestamps.last_heartbeat">

                                    {{ $t('units.hours_ago', {val: controlunit.timestamps.last_heartbeat_diff.hours}) }}
                                </span>
                                <span v-show="controlunit.timestamps.last_heartbeat_diff.days < 1 &&
                                              controlunit.timestamps.last_heartbeat_diff.hours < 1 &&
                                              controlunit.timestamps.last_heartbeat_diff.minutes > 1"
                                      class="tooltipped" data-position="bottom" data-delay="50" v-bind:data-tooltip="controlunit.timestamps.last_heartbeat">

                                    {{ $t('units.minutes_ago', {val: controlunit.timestamps.last_heartbeat_diff.minutes}) }}
                                </span>
                                <span v-show="controlunit.timestamps.last_heartbeat_diff.days < 1 &&
                                              controlunit.timestamps.last_heartbeat_diff.hours < 1 &&
                                              controlunit.timestamps.last_heartbeat_diff.minutes < 2"
                                      class="tooltipped" data-position="bottom" data-delay="50" v-bind:data-tooltip="controlunit.timestamps.last_heartbeat">

                                    {{ $t('units.just_now') }}
                                </span>
                            </td>

                            <td>
                                <span>
                                    <a class="waves-effect waves-light btn-small" v-bind:href="'/controlunits/' + controlunit.id + '/edit'">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </span>
                            </td>

                        </tr>
                        <tr class="collapsible-body">
                            <td colspan="3">
                                {{ $tc('components.physical_sensors', 2) }}:
                                <span v-for="(physical_sensor, index) in controlunit.physical_sensors">
                                    <i class="material-icons">memory</i>
                                    <a v-bind:href="'/physical_sensors/' + physical_sensor.id">{{ physical_sensor.name }}</a>
                                    <template v-if="index < controlunit.physical_sensors.length-1">, </template>
                                </span>
                                <br />
                                {{ $tc('components.valves', 2) }}:
                                <span v-for="(valve, index) in controlunit.valves">
                                    <i class="material-icons">transform</i>
                                    <a v-bind:href="'/valves/' + valve.id">{{ valve.name }}</a>
                                    <template v-if="index < controlunit.valves.length-1">, </template>
                                </span>
                                <br />
                                {{ $tc('components.pumps', 2) }}:
                                <span v-for="(pump, index) in controlunit.pumps">
                                    <i class="material-icons">rotate_right</i>
                                    <a v-bind:href="'/pumps/' + pump.id">{{ pump.name }}</a>
                                    <template v-if="index < controlunit.pumps.length-1">, </template>
                                </span>
                                <br />
                                {{ $tc('components.generic_components', 2) }}:
                                <span v-for="(generic_component, index) in controlunit.generic_components">
                                    <i class="material-icons">{{ generic_component.type.icon }}</i>
                                    <a v-bind:href="'/generic_components/' + generic_component.id">{{ generic_component.name }}</a>
                                    <template v-if="index < controlunit.generic_components.length-1">, </template>
                                </span>
                                <br />
                            </td>
                        </tr>
                    </tbody>
                </template>
            </table>

            <ul class="pagination" v-if="meta.hasOwnProperty('pagination')">
                <li v-bind:class="{ 'disabled': meta.pagination.current_page == 1, 'waves-effect': meta.pagination.current_page != 1 }">
                    <a href="#!" v-on:click="set_page(1)"><i class="material-icons">first_page</i></a>
                </li>
                <li v-bind:class="{ 'disabled': meta.pagination.current_page == 1, 'waves-effect': meta.pagination.current_page != 1 }">
                    <a href="#!" v-on:click="set_page(meta.pagination.current_page-1)"><i class="material-icons">chevron_left</i></a>
                </li>

                <li v-if="meta.pagination.current_page-3 > 0" class="waves-effect"><a href="#!" v-on:click="set_page(meta.pagination.current_page-3)">{{ meta.pagination.current_page-3 }}</a></li>
                <li v-if="meta.pagination.current_page-2 > 0" class="waves-effect"><a href="#!" v-on:click="set_page(meta.pagination.current_page-2)">{{ meta.pagination.current_page-2 }}</a></li>
                <li v-if="meta.pagination.current_page-1 > 0" class="waves-effect"><a href="#!" v-on:click="set_page(meta.pagination.current_page-1)">{{ meta.pagination.current_page-1 }}</a></li>

                <li class="active"><a href="#!">{{ meta.pagination.current_page }}</a></li>

                <li v-if="meta.pagination.current_page+1 <= meta.pagination.total_pages" class="waves-effect"><a href="#!" v-on:click="set_page(meta.pagination.current_page+1)">{{ meta.pagination.current_page+1 }}</a></li>
                <li v-if="meta.pagination.current_page+2 <= meta.pagination.total_pages" class="waves-effect"><a href="#!" v-on:click="set_page(meta.pagination.current_page+2)">{{ meta.pagination.current_page+2 }}</a></li>
                <li v-if="meta.pagination.current_page+3 <= meta.pagination.total_pages" class="waves-effect"><a href="#!" v-on:click="set_page(meta.pagination.current_page+3)">{{ meta.pagination.current_page+3 }}</a></li>

                <li v-bind:class="{ 'disabled': meta.pagination.current_page == meta.pagination.total_pages, 'waves-effect': meta.pagination.current_page != meta.pagination.total_pages }">
                    <a href="#!" v-on:click="set_page(meta.pagination.current_page+1)"><i class="material-icons">chevron_right</i></a>
                </li>
                <li v-bind:class="{ 'disabled': meta.pagination.current_page == meta.pagination.total_pages, 'waves-effect': meta.pagination.current_page != meta.pagination.total_pages }">
                    <a href="#!" v-on:click="set_page(meta.pagination.total_pages)"><i class="material-icons">last_page</i></a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            controlunits: [],
            meta: [],
            filter: {
                name: '',
                model: '',
                'controlunit.name': '',
                'terrarium.display_name': ''
            },
            filter_string: '',
            order: {
                field: 'name',
                direction: 'asc'
            },
            order_string: '',
            page: 1
        }
    },

    props: {
        wrapperClasses: {
            type: String,
            default: '',
            required: false
        },
        refreshTimeoutSeconds: {
            type: Number,
            default: 60,
            required: false
        }
    },

    methods: {
        update: function(ps) {
            var item = null;
            this.controlunits.forEach(function(data, index) {
                if (data.id === ps.controlunit.id) {
                    item = index;
                }
            });
            if (item !== null) {
                this.controlunits.splice(item, 1, ps.controlunit);
            }
        },

        delete: function(ps) {
            var item = null;
            this.controlunits.forEach(function(data, index) {
                if (data.id === ps.controlunit.id) {
                    item = index;
                }
            });

            if (item !== null) {
                this.controlunits.splice(item, 1);
            }
        },
        
        set_order: function(field) {
            if (this.order.field == field || field === null) {
                if (this.order.direction == 'asc') {
                    this.order.direction = 'desc';
                }
                else {
                    this.order.direction = 'asc';
                }
            }
            else {
                this.order.field = field;
            }

            this.order_string = '&order[' + this.order.field + ']=' + this.order.direction;
            this.load_data();
        },
        set_filter: function() {
            this.filter_string = '&';
            for (var prop in this.filter) {
                if (this.filter.hasOwnProperty(prop)) {
                    if (this.filter[prop] !== null
                        && this.filter[prop] !== '') {

                        this.filter_string += 'filter[' + prop + ']=like:*' + this.filter[prop] + '*&';
                    }
                }
            }
            this.load_data();
        },
        set_page: function(page) {
            this.page = page;
            this.load_data();
        },
        load_data: function() {
            window.eventHubVue.processStarted();
            this.order_string = '&order[' + this.order.field + ']=' + this.order.direction;
            var that = this;
            $.ajax({
                url: '/api/v1/controlunits?page=' + that.page + that.filter_string + that.order_string + '&' + that.sourceFilter,
                method: 'GET',
                success: function (data) {
                    that.meta = data.meta;
                    that.controlunits = data.data;
                    that.$nextTick(function() {
                        $('table.collapsible').collapsibletable();
                    });
                    window.eventHubVue.processEnded();
                },
                error: function (error) {
                    console.log(JSON.stringify(error));
                    window.eventHubVue.processEnded();
                }
            });
        }
    },

    created: function() {
        window.echo.private('dashboard-updates')
                .listen('ControlunitUpdated', (e) => {
                this.update(e);
        }).listen('ControlunitDeleted', (e) => {
                this.delete(e);
        });

        this.load_data();

        var that = this;
        if (this.refreshTimeoutSeconds !== null) {
            setInterval(function() {
                that.load_data();
            }, this.refreshTimeoutSeconds * 1000)
        }
    }
}
</script>