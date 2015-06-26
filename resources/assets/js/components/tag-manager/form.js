import $ from 'jquery'
import React from 'react'

export default React.createClass({

    _onSubmit: function(event) {
        event.preventDefault();
        $(document).trigger('component.tag-manager.list.add', {
            title: event.currentTarget[0].value
        });
        event.currentTarget[0].value = '';
    },

    render: function () {
        return (
            <div className="component__tag-manager__form">
                <form className="form-inline" onSubmit={this._onSubmit}>
                    <div className="input-group">
                        <label for="tagInput" className="sr-only">Add a tag</label>
                        <input type="text" name="title" className="form-control" id="tagInput" placeholder="Add a tag" />
                        <span className="input-group-btn">
                            <button className="btn btn-default">Add</button>
                        </span>
                    </div>
                </form>
            </div>
        )
    }
});