###
# Hubot Brain
# Default Method "Calls" Hubot
# by speaking to him starting 
# with a '.' (No Quotes)
#
# Update your URL
####

module.exports = (robot) ->
        robot.hear /^\.(.*)/i, (msg)->
                topic = escape(msg.match[0])
                askBot msg, "http://localhost/hubotbrain.php?cmd="+topic+"&token=2ee9a2ec7ebffaecc61f8f011981852e"

        askBot = (msg, url) ->
                msg.http(url)
                        .get() (err, res, body) ->
                                msg.send body

