import $ from 'jquery'
import _ from 'lodash'
import React from 'react'

export default React.createClass({

    getDefaultProps: function () {
        return {
            config: {},
            root: ''
        }
    },

    render: function () {
        return (
            <nav>
                <ul className="component-paginator component-paginator--length-aware pagination">
                    {( this.props.config.currentPage !== 1 ?
                        <li className="component-paginator__item component-paginator__item--prev">
                            <a href={'/#'+ this.props.root +'?page=' + (this.props.config.currentPage - 1)}  aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        : <li><span aria-hidden="true">&laquo;</span></li>
                    )}
                    {_.range(this.props.config.currentPage - 5, this.props.config.currentPage + 5).map(function (value) {
                        var isActive = (value === this.props.config.currentPage) ? ' active' : '';
                        if (value > 0 && value <= this.props.config.lastPage) {
                            return (
                                <li className={'component-paginator__item' + isActive}>
                                    <a href={'/#'+ this.props.root +'?page=' + value} >{value}</a>
                                </li>
                            )
                        }
                    }.bind(this))}
                    {( this.props.config.currentPage !== this.props.config.lastPage ?
                        <li className="component-paginator__item component-paginator__item--next">
                            <a href={'/#'+ this.props.root +'?page=' + (this.props.config.currentPage + 1)} aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        : <li><span aria-hidden="true">&raquo;</span></li>
                    )}
                </ul>
            </nav>
        )
    }
});