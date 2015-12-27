Imports Newtonsoft.Json
Public Class Guild
    Public GuildName As String
    Public Emblem As String
    Public Logs As List(Of String)
    Public Motd As String

    Public Sub New(guildName As String, emblem As String, logs As List(Of String), motd As String)

        Me.Emblem = emblem
        Me.GuildName = guildName
        Me.Logs = logs
        Me.Motd = motd


    End Sub

    Public Sub New(json As String)
        JsonConvert.DeserializeObject(Of Guild)(json)
    End Sub
End Class
